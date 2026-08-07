// Shared position/keyword config for CV targeting.
// Single source of truth for CVPage (project scoring) and CVTemplate (skill/cert ranking).
export const POSITION_OPTIONS = [
  { value: 'all', label: 'All Projects (General)', keywords: [] },
  {
    value: 'flutter',
    label: 'Flutter Developer',
    keywords: ['flutter', 'dart', 'riverpod', 'bloc', 'provider', 'firebase', 'rest api'],
  },
  {
    value: 'android',
    label: 'Android Developer',
    keywords: ['kotlin', 'android', 'java', 'jetpack', 'compose', 'mvvm', 'room', 'retrofit'],
  },
  {
    value: 'ios',
    label: 'iOS Developer',
    keywords: ['swift', 'ios', 'swiftui', 'uikit', 'combine', 'core data', 'xcode'],
  },
  {
    value: 'react-native',
    label: 'React Native Developer',
    keywords: ['react native', 'react-native', 'typescript', 'redux', 'react', 'expo'],
  },
  {
    value: 'mobile',
    label: 'Mobile Developer (General)',
    keywords: ['mobile', 'kotlin', 'swift', 'flutter', 'react native', 'android', 'ios'],
  },
  {
    value: 'web',
    label: 'Web Developer',
    keywords: ['react', 'javascript', 'typescript', 'web', 'vite', 'tailwind', 'html', 'css', 'node'],
  },
];

export const getPositionKeywords = (positionValue) =>
  POSITION_OPTIONS.find((p) => p.value === positionValue)?.keywords || [];
