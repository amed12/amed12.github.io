import { describe, it, expect } from 'vitest';
import { scoreProject, filterProjectsByPosition, filterProjectsByPositions } from './cvScoring';

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

const androidProject = {
  title: 'SIBEA Field App',
  description: 'Android app built with Kotlin and Jetpack Compose.',
  technologies: ['Kotlin', 'Android', 'Jetpack Compose'],
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

describe('filterProjectsByPositions', () => {
  const projects = [flutterProject, webProject, androidProject];

  it('returns projects unchanged when no positions given', () => {
    expect(filterProjectsByPositions(projects, [])).toBe(projects);
    expect(filterProjectsByPositions(projects, undefined)).toBe(projects);
  });

  it('unions keywords across multiple positions and dedups matches', () => {
    const result = filterProjectsByPositions(projects, ['flutter', 'android']);
    expect(result).toHaveLength(2);
    expect(result.map((p) => p.title).sort()).toEqual(
      ['Ceklok Attendance App', 'SIBEA Field App'].sort()
    );
  });

  it('ignores unknown positions and "all"', () => {
    const result = filterProjectsByPositions(projects, ['all', 'not-a-real-position', 'flutter']);
    expect(result).toHaveLength(1);
    expect(result[0].title).toBe('Ceklok Attendance App');
  });

  it('falls back to all projects when nothing matches', () => {
    const result = filterProjectsByPositions(projects, ['ios']);
    expect(result).toEqual(projects);
  });

  it('returns projects unchanged when only invalid positions given', () => {
    expect(filterProjectsByPositions(projects, ['all', 'nope'])).toBe(projects);
  });
});
