import { describe, it, expect, beforeEach, vi } from 'vitest';
import { saveData, getData, resetData, hasUnpublishedChanges } from './dataManager';

const sampleData = { profile: { name: 'Test User' } };

describe('dataManager', () => {
  beforeEach(() => {
    localStorage.clear();
    vi.restoreAllMocks();
  });

  describe('saveData / hasUnpublishedChanges', () => {
    it('writes to localStorage and reports unpublished changes', () => {
      expect(hasUnpublishedChanges()).toBe(false);
      expect(saveData(sampleData)).toBe(true);
      expect(hasUnpublishedChanges()).toBe(true);
      expect(JSON.parse(localStorage.getItem('portfolioData'))).toEqual(sampleData);
    });
  });

  describe('getData', () => {
    it('returns localStorage draft when present', async () => {
      saveData(sampleData);
      const result = await getData();
      expect(result).toEqual(sampleData);
    });

    it('falls back to fetching data.json when no draft exists', async () => {
      const fetchedData = { profile: { name: 'Fetched User' } };
      globalThis.fetch = vi.fn().mockResolvedValue({
        ok: true,
        json: () => Promise.resolve(fetchedData),
      });

      const result = await getData();
      expect(globalThis.fetch).toHaveBeenCalled();
      expect(result).toEqual(fetchedData);
    });
  });

  describe('resetData', () => {
    it('clears localStorage and re-fetches the base data', async () => {
      saveData(sampleData);
      const fetchedData = { profile: { name: 'Original User' } };
      globalThis.fetch = vi.fn().mockResolvedValue({
        ok: true,
        json: () => Promise.resolve(fetchedData),
      });

      const result = await resetData();
      expect(hasUnpublishedChanges()).toBe(false);
      expect(result).toEqual(fetchedData);
    });
  });
});
