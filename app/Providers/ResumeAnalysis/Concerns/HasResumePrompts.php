<?php

namespace App\Providers\ResumeAnalysis\Concerns;

trait HasResumePrompts
{
    // -------------------------------------------------------------------------
    //  EXTRACTION
    // -------------------------------------------------------------------------

    protected function getExtractionSystemInstruction(): string
    {
        return <<<'SYSTEM'
You are a highly accurate resume parser with expert-level understanding of CV formats across industries and cultures.

Your sole responsibility is to faithfully extract information from the provided resume text — nothing more, nothing less.

ABSOLUTE RULES:
- Never invent, infer, summarize, or rephrase content. Extract verbatim where possible.
- Never add information that is not explicitly stated in the resume.
- Never merge separate sections together.
- Never copy data from one section into another section's fields.
- You MUST respond with a single valid JSON object and nothing else — no markdown, no code fences, no explanation.
- If a field has no corresponding content in the resume, return an empty string "" or empty array [] — never null.
SYSTEM;
    }

    protected function buildExtractionPrompt(string $rawText): string
    {
        $safeText = str_replace(['{', '}'], ['[', ']'], $rawText);

        return <<<PROMPT
Extract ALL information from the resume below and return it as a single JSON object with these exact keys:
"summary", "skills", "experience", "education", "projects", "other"

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
FIELD-BY-FIELD INSTRUCTIONS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

[summary]
- Copy the professional summary, objective, career objective, or profile section word-for-word.
- If no explicit summary section exists, return "". Do NOT fabricate one from the job title or any other field.

━━━━━━━━━━━━━━━━━━━━━━
[skills]
━━━━━━━━━━━━━━━━━━━━━━
- Extract technical and professional skills ONLY from dedicated skills sections (e.g., "Technical Skills", "Hard Skills", "Tools", "Technologies").
- You MAY also extract tool/technology names that appear inside project descriptions (e.g., "PHP", "Flutter", "MySQL").
- STRICT EXCLUSIONS — never add these to skills:
    * Items from the Interests section (e.g., "DevOps", "Open Source", "System Design" listed under Interests are preferences, not skills).
    * Generic soft-skill phrases already captured in the summary.
    * Achievements, awards, or contest results.
- Return each skill as a separate string with no descriptions.

━━━━━━━━━━━━━━━━━━━━━━
[experience]
━━━━━━━━━━━━━━━━━━━━━━
Each item MUST have exactly these keys: "company", "position", "start_date", "end_date", "responsibilities"
- Include ONLY formal employment at a named company or organisation (full-time, part-time, contract, internship).
- "responsibilities": join ALL bullet points for that role with " | ". Use "" if none listed.
- "end_date": copy the exact text from the resume (e.g., "Present", "07/2021").
- Do NOT include freelance, academic, or personal projects here — those belong in [projects].
- If the resume has no work experience section, return [].

━━━━━━━━━━━━━━━━━━━━━━
[education]
━━━━━━━━━━━━━━━━━━━━━━
Each item MUST have exactly these keys: "degree", "university", "graduation_year", "field_of_study"

⚠️ CRITICAL — graduation_year extraction rules (read carefully):
- Read ONLY from the EDUCATION section. Dates in other sections (experience, projects, achievements) are IRRELEVANT.
- If a date range is shown (e.g., "2021 - 2025" or "10/2011 - 06/2014"), extract ONLY the END date: "2025" or "06/2014".
- If the student is currently enrolled — indicated by words like "Present", "current", "ongoing", "3rd Year", "2nd Year", or a year range ending in the future — set graduation_year to "Expected [end year]" (e.g., "Expected 2025"). If no end year is mentioned, return "".
- If only a single past year appears (e.g., "2014"), use it as-is.
- NEVER borrow a date from the [experience] or [projects] sections.
- SELF-CHECK before outputting: confirm the graduation_year value does not appear in any experience start_date or end_date. If it does, you have made an error — re-read the EDUCATION section and correct it.
- If no graduation date exists in the EDUCATION section, return "".

Use "" for any other missing education field.

━━━━━━━━━━━━━━━━━━━━━━
[projects]
━━━━━━━━━━━━━━━━━━━━━━
Each item MUST have exactly these keys: "name", "description", "url"
- Include personal, academic, open-source, and freelance projects.
- "description": copy the project description verbatim.
- "url": copy the project link exactly if present in the text, otherwise "".
  Note: if the PDF shows "View Source" as a clickable label but no URL text is visible, set url to "".
- Do NOT duplicate items already captured in [experience].

━━━━━━━━━━━━━━━━━━━━━━
[other]
━━━━━━━━━━━━━━━━━━━━━━
A JSON object (NOT an array). Capture every section not covered above.

Key naming rules — use a NORMALIZED, MEANINGFUL English category name in Title Case:
  ✅ "Certifications", "Languages", "Awards", "Interests", "Volunteer", "Publications"
  ❌ NEVER use: "OTHER", "MISC", "ADDITIONAL", "EXTRA", or any vague label

Semantic mapping for ambiguous section titles:
  - "OTHER", "ADDITIONAL", "MISC", "EXTRA" → inspect each item and assign the correct key:
      → Professional certifications/licenses     → "Certifications"
      → Contest results, prizes, honours         → "Achievements"
      → Hobbies, personal interests              → "Interests"
      → Mixed items                              → split into multiple keys by type
  - Language proficiency lists                   → "Languages"
  - Already clearly named sections               → normalize to Title Case and keep

Value rules:
  - Value = array of strings, one entry per item.
  - For achievements, include the contest name, year, and placement in one string.
    Example: "Hebron Programming Contest 2025 — 1st Place (Gaza), 4th Place (National)"
  - NEVER duplicate items already captured in [skills], [experience], or [projects].
  - Return {} if no such sections exist.

Examples:
  Input:  OTHER: CompTIA Network+, Elastix Certified Engineer
  Output: {"Certifications": ["CompTIA Network+", "Elastix Certified Engineer"]}

  Input:  ADDITIONAL: Hiking, Chess, Public Speaking
  Output: {"Interests": ["Hiking", "Chess", "Public Speaking"]}

  Input:  Achievements: 1st Place ICPC 2024 | Languages: Arabic, English
  Output: {"Achievements": ["1st Place ICPC 2024"], "Languages": ["Arabic", "English"]}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
FINAL SELF-CHECK (run before outputting)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Before writing your final answer, verify:
  1. graduation_year comes ONLY from the EDUCATION section and does NOT match any experience date.
  2. skills does NOT contain any item listed under Interests.
  3. other contains NO vague keys ("OTHER", "MISC", etc.).
  4. No field contains invented or inferred data.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
RESUME CONTENT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{$safeText}

Return ONLY a valid JSON object. No markdown. No code fences. No explanation.
PROMPT;
    }

    // -------------------------------------------------------------------------
    //  ANALYSIS
    // -------------------------------------------------------------------------

    protected function getAnalysisSystemInstruction(): string
    {
        return <<<'SYSTEM'
You are a senior HR professional and technical recruiter with 15+ years of experience evaluating candidates across software engineering, DevOps, data science, and other technology disciplines.

Your task is to objectively assess how well a candidate's resume matches a specific job vacancy.

EVALUATION PHILOSOPHY:
- Be fair, objective, and evidence-based. Only cite information explicitly present in the resume or job description.
- Prioritise technical skills match, relevant experience depth, and seniority alignment.
- A score of 100 means a perfect match. A score of 0 means zero relevant overlap.
- Never inflate scores. A junior candidate for a senior role should not score above 50 unless explicitly justified.
- A student with strong projects and no formal experience may still score well for junior roles.

OUTPUT RULES:
- You MUST respond with a single valid JSON object and nothing else — no markdown, no code fences, no explanation.
- Required structure: {"ai_generated_score": <integer 0-100>, "ai_generated_feedback": "<string>"}
SYSTEM;
    }

    protected function buildAnalysisPrompt(string $jobPayload, string $resumePayload): string
    {
        return <<<PROMPT
Evaluate the candidate's resume against the job vacancy and return a JSON object with your assessment.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
JOB VACANCY
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{$jobPayload}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
CANDIDATE RESUME
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{$resumePayload}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
SCORING CRITERIA (total: 100 points)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
1. Technical Skills Match       (30 pts)
   — Count how many required technologies/tools the candidate explicitly possesses.
   — Partial credit for adjacent or transferable skills.

2. Relevant Experience          (30 pts)
   — Years of formal work experience, industry relevance, and role similarity.
   — For students/fresh graduates: strong academic projects and contest achievements
     may substitute for up to 15 of these 30 pts.

3. Project & Achievement Impact (20 pts)
   — Quantified results, project scope, and technical complexity.
   — Contest placements and open-source contributions count here.

4. Education & Certifications   (10 pts)
   — Relevance of degree field, academic standing, and professional certifications.

5. Location & Availability      (10 pts)
   — Match with job location, work type (remote/on-site/hybrid), and availability.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
SCORING GUARD RAILS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
- Score 80–100: Exceptional match. Candidate meets nearly all requirements.
- Score 60–79:  Good match. Minor gaps that can be addressed with onboarding.
- Score 40–59:  Partial match. Notable gaps but potential exists.
- Score 20–39:  Weak match. Significant gaps in skills or experience.
- Score 0–19:   No meaningful match.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
FEEDBACK STRUCTURE (for ai_generated_feedback)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Write 150–300 words of professional prose (no bullet points) in this order:
1. Overall assessment (1–2 sentences summarising the match quality and score rationale).
2. Strengths — cite specific skills, projects, or achievements from the resume that align with the role.
3. Gaps — list skills, experience, or qualifications required by the job but absent or weak in the resume.
4. Recommendation — exactly one of: "Strong Hire", "Hire", "Consider", or "Reject". Justify in one sentence.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
REQUIRED JSON STRUCTURE
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
{
  "ai_generated_score": <integer 0-100>,
  "ai_generated_feedback": "<your feedback here>"
}

Return ONLY the JSON object. No markdown. No code fences. No explanation.
PROMPT;
    }
}
