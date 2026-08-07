import { getPositionKeywords } from '../config/positions';

const SKILL_CATEGORY_KEYWORDS = {
  languages: ['java', 'kotlin', 'javascript', 'python', 'dart', 'php', 'swift', 'typescript'],
  frameworks: ['react', 'flutter', 'laravel', 'codeigniter', 'bootstrap', 'jquery', 'android', 'swiftui', 'compose'],
  tools: ['git', 'docker', 'firebase', 'aws', 'xcode', 'android studio'],
};

// Resolve the bio to show: position-specific summary if available, else the general bio.
export const getBioForPosition = (profile, targetPosition) =>
  (targetPosition !== 'all' && profile?.positionSummaries?.[targetPosition]) || profile?.bio;

// Sort skills by relevance to target position using the shared position keyword config.
export const sortSkillsByRelevance = (skillsList, targetPosition) => {
  if (!skillsList || targetPosition === 'all') return skillsList;

  const priorities = getPositionKeywords(targetPosition);
  return [...skillsList].sort((a, b) => {
    const aName = a.name.toLowerCase();
    const bName = b.name.toLowerCase();

    const aScore = priorities.findIndex((p) => aName.includes(p));
    const bScore = priorities.findIndex((p) => bName.includes(p));

    if (aScore === -1 && bScore === -1) return 0;
    if (aScore === -1) return 1;
    if (bScore === -1) return -1;
    return aScore - bScore;
  });
};

// Filter certifications by relevance, keeping the top 5.
export const filterCertifications = (certs, targetPosition) => {
  if (!certs || targetPosition === 'all') return certs;

  const relevantKeywords = getPositionKeywords(targetPosition);
  const scored = certs.map((cert) => {
    const combined = `${cert.title} ${cert.issuer}`.toLowerCase();
    const score = relevantKeywords.filter((kw) => combined.includes(kw)).length;
    return { ...cert, score };
  });

  return scored.sort((a, b) => b.score - a.score).slice(0, 5);
};

// Group skills by category (language/framework/tool) for section rendering.
export const groupSkillsByCategory = (sortedSkills) => ({
  languages: sortedSkills?.filter((s) =>
    SKILL_CATEGORY_KEYWORDS.languages.some((lang) => s.name.toLowerCase().includes(lang))
  ) || [],
  frameworks: sortedSkills?.filter((s) =>
    SKILL_CATEGORY_KEYWORDS.frameworks.some((fw) => s.name.toLowerCase().includes(fw))
  ) || [],
  tools: sortedSkills?.filter((s) =>
    SKILL_CATEGORY_KEYWORDS.tools.some((tool) => s.name.toLowerCase().includes(tool))
  ) || [],
});
