// @vitest-environment node
// Guards public/data.json. It is published as-is and feeds the exported CV,
// so anything that slips in here is public (see CLAUDE.md "Content rules").
import { describe, it, expect } from 'vitest';
import { readFileSync } from 'node:fs';

const data = JSON.parse(readFileSync(new URL('../public/data.json', import.meta.url), 'utf8'));

const ID_LISTS = ['experience', 'education', 'certifications', 'honors', 'projects', 'testimonials'];

describe('public/data.json', () => {
  it('has the sections the pages read', () => {
    for (const key of ['profile', 'skills', ...ID_LISTS]) {
      expect(data, `missing "${key}"`).toHaveProperty(key);
    }
    expect(data.profile.name).toBeTruthy();
  });

  it('contains no TODO markers or internal notes', () => {
    const raw = JSON.stringify(data);
    expect(raw).not.toMatch(/TODO:/);
    expect(data).not.toHaveProperty('cv_improvement_notes');
  });

  it.each(ID_LISTS)('%s entries have unique ids', (key) => {
    const ids = data[key].map((item) => item.id);
    expect(ids.every(Boolean)).toBe(true);
    expect(new Set(ids).size).toBe(ids.length);
  });

  it('every project has a title, category and description', () => {
    const incomplete = data.projects
      .filter((p) => !p.title || !p.category || !p.description?.trim())
      .map((p) => p.id);
    expect(incomplete).toEqual([]);
  });
});
