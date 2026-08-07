import { getPositionKeywords, POSITION_OPTIONS } from '../config/positions';

// Score a single project's relevance to a position by counting keyword hits
// across its technologies, title, and description.
export const scoreProject = (project, keywords) => {
  const techString = project.technologies?.join(' ').toLowerCase() || '';
  const title = project.title.toLowerCase();
  const description = project.description.toLowerCase();
  const combined = `${techString} ${title} ${description}`;

  return keywords.reduce(
    (score, keyword) => (combined.includes(keyword.toLowerCase()) ? score + 1 : score),
    0
  );
};

// Filter+sort projects by relevance to a target position.
// Falls back to the full unfiltered list if nothing scores above zero.
export const filterProjectsByPosition = (projects, positionValue) => {
  if (!projects || positionValue === 'all') return projects;

  const keywords = getPositionKeywords(positionValue);
  if (!keywords.length) return projects;

  const scoredProjects = projects.map((project) => ({
    ...project,
    relevanceScore: scoreProject(project, keywords),
  }));

  const sortedProjects = scoredProjects
    .filter((p) => p.relevanceScore > 0)
    .sort((a, b) => b.relevanceScore - a.relevanceScore);

  return sortedProjects.length > 0 ? sortedProjects : projects;
};

// Filter+sort projects by relevance to a union of target positions.
// Unknown positions and 'all' are ignored. Falls back to the full list
// if there are no valid positions or nothing scores above zero.
export const filterProjectsByPositions = (projects, positionValues) => {
  if (!projects || !positionValues?.length) return projects;

  const validValues = POSITION_OPTIONS.map((p) => p.value);
  const keywords = [
    ...new Set(
      positionValues
        .filter((value) => value !== 'all' && validValues.includes(value))
        .flatMap((value) => getPositionKeywords(value))
    ),
  ];
  if (!keywords.length) return projects;

  const scoredProjects = projects.map((project) => ({
    ...project,
    relevanceScore: scoreProject(project, keywords),
  }));

  const sortedProjects = scoredProjects
    .filter((p) => p.relevanceScore > 0)
    .sort((a, b) => b.relevanceScore - a.relevanceScore);

  return sortedProjects.length > 0 ? sortedProjects : projects;
};
