import { describe, it, expect } from 'vitest';
import { scoreProject, filterProjectsByPosition } from './cvScoring';

const flutterProject = {
  title: 'Ceklok Attendance App',
  description: 'Built with Flutter and Riverpod for state management.',
  technologies: ['Flutter', 'Dart', 'Firebase'],
};

const webProject = {
  title: 'Portfolio Site',
  description: 'A personal site built with React and Tailwind.',
  technologies: ['React', 'Vite', 'Tailwind'],
};

describe('scoreProject', () => {
  it('counts keyword hits across technologies, title, and description', () => {
    const score = scoreProject(flutterProject, ['flutter', 'dart', 'riverpod', 'bloc']);
    expect(score).toBe(3);
  });

  it('returns 0 when no keywords match', () => {
    const score = scoreProject(webProject, ['flutter', 'dart', 'riverpod', 'bloc']);
    expect(score).toBe(0);
  });
});

describe('filterProjectsByPosition', () => {
  const projects = [flutterProject, webProject];

  it('returns all projects unchanged for "all"', () => {
    expect(filterProjectsByPosition(projects, 'all')).toBe(projects);
  });

  it('filters and sorts by relevance for a known position', () => {
    const result = filterProjectsByPosition(projects, 'flutter');
    expect(result).toHaveLength(1);
    expect(result[0].title).toBe('Ceklok Attendance App');
  });

  it('falls back to all projects when nothing matches', () => {
    const result = filterProjectsByPosition(projects, 'ios');
    expect(result).toEqual(projects);
  });
});
