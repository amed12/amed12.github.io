// Local Storage Manager for Career Dashboard

const STORAGE_KEYS = {
  TODOS: 'career_dashboard_todos',
  APPLICATIONS: 'career_dashboard_applications',
  WEEKLY_GOALS: 'career_dashboard_weekly_goals',
  SKILLS: 'career_dashboard_skills',
  ACHIEVEMENTS: 'career_dashboard_achievements',
  NETWORKING: 'career_dashboard_networking',
  ACTION_ITEMS: 'career_dashboard_action_items'
};

// ============ TODOs Management ============

export const getTodos = () => {
  try {
    const stored = localStorage.getItem(STORAGE_KEYS.TODOS);
    return stored ? JSON.parse(stored) : getDefaultTodos();
  } catch (error) {
    console.error('Error getting todos:', error);
    return getDefaultTodos();
  }
};

export const saveTodos = (todos) => {
  try {
    localStorage.setItem(STORAGE_KEYS.TODOS, JSON.stringify(todos));
    return true;
  } catch (error) {
    console.error('Error saving todos:', error);
    return false;
  }
};

export const toggleTodo = (experienceId, todoIndex) => {
  const todos = getTodos();
  if (todos[experienceId] && todos[experienceId].todos[todoIndex]) {
    todos[experienceId].todos[todoIndex].done = !todos[experienceId].todos[todoIndex].done;
    saveTodos(todos);
  }
  return todos;
};

export const getDefaultTodos = () => {
  return {
    exp1: {
      experience: 'Mobile Engineer @ Qiscus (Current)',
      todos: [
        { text: 'Add user count/scale (e.g., "serving 2M+ users")', priority: 'high', done: false },
        { text: 'Add performance metrics (startup time, crash rate)', priority: 'high', done: false },
        { text: 'Add CI/CD frequency (releases per month)', priority: 'medium', done: false },
        { text: 'Add team size mentored', priority: 'medium', done: false },
        { text: 'Add SLA/uptime metrics', priority: 'low', done: false },
        { text: 'Add security practices implemented', priority: 'medium', done: false }
      ]
    },
    exp2: {
      experience: 'Android Developer @ Qiscus',
      todos: [
        { text: 'List specific features built (chat, file sharing, notifications)', priority: 'high', done: false },
        { text: 'Add Jetpack Compose migration details', priority: 'medium', done: false },
        { text: 'Add testing examples (test case count)', priority: 'medium', done: false },
        { text: 'Add API performance improvements', priority: 'low', done: false },
        { text: 'Add cold start/memory optimization metrics', priority: 'medium', done: false },
        { text: 'List advanced features (WorkManager, Room, FCM)', priority: 'low', done: false }
      ]
    },
    exp3: {
      experience: 'iOS Developer @ Apple Academy',
      todos: [
        { text: 'List apps published/developed', priority: 'high', done: false },
        { text: 'Add app complexity (screen count, frameworks)', priority: 'medium', done: false },
        { text: 'Add features implemented', priority: 'medium', done: false },
        { text: 'Add test coverage achieved', priority: 'low', done: false },
        { text: 'Add team details (size, presentations)', priority: 'low', done: false }
      ]
    },
    exp4: {
      experience: 'Android Developer @ Vascomm',
      todos: [
        { text: 'Add number of client projects', priority: 'high', done: false },
        { text: 'List features implemented', priority: 'medium', done: false },
        { text: 'Add bug fixing impact', priority: 'low', done: false }
      ]
    },
    exp5: {
      experience: 'Bank Mandiri Taspen',
      todos: [
        { text: 'Add project scope (user count, features)', priority: 'medium', done: false },
        { text: 'List banking features implemented', priority: 'medium', done: false },
        { text: 'Add security practices applied', priority: 'low', done: false }
      ]
    }
  };
};

// ============ Applications Management ============

export const getApplications = () => {
  try {
    const stored = localStorage.getItem(STORAGE_KEYS.APPLICATIONS);
    return stored ? JSON.parse(stored) : getDefaultApplications();
  } catch (error) {
    console.error('Error getting applications:', error);
    return getDefaultApplications();
  }
};

export const saveApplications = (applications) => {
  try {
    localStorage.setItem(STORAGE_KEYS.APPLICATIONS, JSON.stringify(applications));
    return true;
  } catch (error) {
    console.error('Error saving applications:', error);
    return false;
  }
};

export const updateApplication = (companyId, updates) => {
  const apps = getApplications();
  if (apps[companyId]) {
    apps[companyId] = { ...apps[companyId], ...updates };
    saveApplications(apps);
  }
  return apps;
};

export const getDefaultApplications = () => {
  return {
    permatabank: {
      id: 'permatabank',
      company: 'PermataBank',
      position: 'Mobile Developer',
      status: 'not-applied',
      match: 90,
      priority: 'high',
      appliedDate: null,
      interviewDate: null,
      notes: '',
      followUpDate: null
    },
    grab_android: {
      id: 'grab_android',
      company: 'Grab Android',
      position: 'Senior Android Engineer',
      status: 'not-applied',
      match: 90,
      priority: 'high',
      appliedDate: null,
      interviewDate: null,
      notes: '',
      followUpDate: null
    },
    grab_grabkios: {
      id: 'grab_grabkios',
      company: 'Grab GrabKios',
      position: 'Flutter Engineer',
      status: 'not-applied',
      match: 85,
      priority: 'medium',
      appliedDate: null,
      interviewDate: null,
      notes: '',
      followUpDate: null
    },
    kredivo: {
      id: 'kredivo',
      company: 'Kredivo',
      position: 'Android SDE 2',
      status: 'not-applied',
      match: 85,
      priority: 'medium',
      appliedDate: null,
      interviewDate: null,
      notes: '',
      followUpDate: null
    },
    astro: {
      id: 'astro',
      company: 'ASTRO',
      position: 'Senior Mobile Engineer',
      status: 'not-applied',
      match: 80,
      priority: 'medium',
      appliedDate: null,
      interviewDate: null,
      notes: '',
      followUpDate: null
    }
  };
};

// ============ Weekly Goals Management ============

export const getWeeklyGoals = () => {
  try {
    const stored = localStorage.getItem(STORAGE_KEYS.WEEKLY_GOALS);
    return stored ? JSON.parse(stored) : getDefaultWeeklyGoals();
  } catch (error) {
    console.error('Error getting weekly goals:', error);
    return getDefaultWeeklyGoals();
  }
};

export const saveWeeklyGoals = (goals) => {
  try {
    localStorage.setItem(STORAGE_KEYS.WEEKLY_GOALS, JSON.stringify(goals));
    return true;
  } catch (error) {
    console.error('Error saving weekly goals:', error);
    return false;
  }
};

export const toggleWeeklyGoal = (goalIndex) => {
  const goals = getWeeklyGoals();
  if (goals[goalIndex]) {
    goals[goalIndex].completed = !goals[goalIndex].completed;
    saveWeeklyGoals(goals);
  }
  return goals;
};

export const getDefaultWeeklyGoals = () => {
  return [
    { task: 'Apply to 2 companies', completed: false },
    { task: 'Fill critical TODOs', completed: false },
    { task: 'Update LinkedIn profile', completed: false },
    { task: 'Request 2 recommendations', completed: false },
    { task: 'Start learning UI Automator', completed: false }
  ];
};

// ============ Statistics Calculation ============

export const getStats = () => {
  const todos = getTodos();
  const apps = getApplications();
  const goals = getWeeklyGoals();

  // Calculate TODO stats
  let totalTodos = 0;
  let completedTodos = 0;
  Object.values(todos).forEach(exp => {
    exp.todos.forEach(todo => {
      totalTodos++;
      if (todo.done) completedTodos++;
    });
  });

  // Calculate application stats
  const appValues = Object.values(apps);
  const appliedCount = appValues.filter(app => app.status !== 'not-applied').length;
  const interviewCount = appValues.filter(app => app.status === 'interview').length;
  const offerCount = appValues.filter(app => app.status === 'offer').length;

  // Calculate goals stats
  const completedGoals = goals.filter(g => g.completed).length;
  const totalGoals = goals.length;

  return {
    todos: { completed: completedTodos, total: totalTodos },
    applications: { applied: appliedCount, interview: interviewCount, offer: offerCount, total: appValues.length },
    goals: { completed: completedGoals, total: totalGoals },
    cvMatchScore: 86
  };
};

// ============ Utility Functions ============

export const formatDate = (date) => {
  if (!date) return '';
  const d = new Date(date);
  return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
};

export const getDaysUntil = (date) => {
  if (!date) return null;
  const today = new Date();
  const target = new Date(date);
  const diff = Math.ceil((target - today) / (1000 * 60 * 60 * 24));
  return diff;
};

export const clearAllData = () => {
  localStorage.removeItem(STORAGE_KEYS.TODOS);
  localStorage.removeItem(STORAGE_KEYS.APPLICATIONS);
  localStorage.removeItem(STORAGE_KEYS.WEEKLY_GOALS);
  localStorage.removeItem(STORAGE_KEYS.SKILLS);
  localStorage.removeItem(STORAGE_KEYS.ACHIEVEMENTS);
  localStorage.removeItem(STORAGE_KEYS.NETWORKING);
  localStorage.removeItem(STORAGE_KEYS.ACTION_ITEMS);
};

// ============ Skills Management ============

export const getSkills = () => {
  try {
    const stored = localStorage.getItem(STORAGE_KEYS.SKILLS);
    return stored ? JSON.parse(stored) : getDefaultSkills();
  } catch (error) {
    console.error('Error getting skills:', error);
    return getDefaultSkills();
  }
};

export const saveSkills = (skills) => {
  try {
    localStorage.setItem(STORAGE_KEYS.SKILLS, JSON.stringify(skills));
    return true;
  } catch (error) {
    console.error('Error saving skills:', error);
    return false;
  }
};

export const updateSkillProgress = (skillId, progress) => {
  const skills = getSkills();
  if (skills[skillId]) {
    skills[skillId].progress = progress;
    skills[skillId].lastUpdated = new Date().toISOString();
    saveSkills(skills);
  }
  return skills;
};

export const getDefaultSkills = () => {
  return {
    ui_automator: {
      id: 'ui_automator',
      name: 'UI Automator',
      category: 'Testing',
      priority: 'high',
      progress: 0,
      target: 100,
      status: 'not-started',
      resources: ['Android Docs', 'Udemy Course'],
      lastUpdated: null
    },
    espresso_advanced: {
      id: 'espresso_advanced',
      name: 'Espresso Advanced',
      category: 'Testing',
      priority: 'high',
      progress: 0,
      target: 100,
      status: 'not-started',
      resources: ['Official Guide'],
      lastUpdated: null
    },
    perfetto: {
      id: 'perfetto',
      name: 'Perfetto',
      category: 'Performance',
      priority: 'medium',
      progress: 0,
      target: 100,
      status: 'not-started',
      resources: ['Perfetto Docs'],
      lastUpdated: null
    },
    systrace: {
      id: 'systrace',
      name: 'Systrace',
      category: 'Performance',
      priority: 'medium',
      progress: 0,
      target: 100,
      status: 'not-started',
      resources: ['Android Docs'],
      lastUpdated: null
    }
  };
};

// ============ Achievements Management ============

export const getAchievements = () => {
  try {
    const stored = localStorage.getItem(STORAGE_KEYS.ACHIEVEMENTS);
    return stored ? JSON.parse(stored) : getDefaultAchievements();
  } catch (error) {
    console.error('Error getting achievements:', error);
    return getDefaultAchievements();
  }
};

export const saveAchievements = (achievements) => {
  try {
    localStorage.setItem(STORAGE_KEYS.ACHIEVEMENTS, JSON.stringify(achievements));
    return true;
  } catch (error) {
    console.error('Error saving achievements:', error);
    return false;
  }
};

export const addAchievement = (achievement) => {
  const achievements = getAchievements();
  const newAchievement = {
    id: Date.now().toString(),
    ...achievement,
    date: achievement.date || new Date().toISOString()
  };
  achievements.push(newAchievement);
  saveAchievements(achievements);
  return achievements;
};

export const getDefaultAchievements = () => {
  return [];
};

// ============ Networking Management ============

export const getNetworking = () => {
  try {
    const stored = localStorage.getItem(STORAGE_KEYS.NETWORKING);
    return stored ? JSON.parse(stored) : getDefaultNetworking();
  } catch (error) {
    console.error('Error getting networking:', error);
    return getDefaultNetworking();
  }
};

export const saveNetworking = (networking) => {
  try {
    localStorage.setItem(STORAGE_KEYS.NETWORKING, JSON.stringify(networking));
    return true;
  } catch (error) {
    console.error('Error saving networking:', error);
    return false;
  }
};

export const updateNetworkingMetric = (platform, metric, value) => {
  const networking = getNetworking();
  if (networking[platform]) {
    networking[platform][metric] = value;
    networking[platform].lastUpdated = new Date().toISOString();
    saveNetworking(networking);
  }
  return networking;
};

export const getDefaultNetworking = () => {
  return {
    linkedin: {
      platform: 'LinkedIn',
      connections: 0,
      profileViews: 0,
      postEngagement: 0,
      recommendationsReceived: 0,
      recommendationsGiven: 0,
      lastUpdated: null
    },
    github: {
      platform: 'GitHub',
      followers: 0,
      contributions: 0,
      stars: 0,
      repositories: 0,
      lastUpdated: null
    }
  };
};

// ============ Action Items Management ============

export const getActionItems = () => {
  try {
    const stored = localStorage.getItem(STORAGE_KEYS.ACTION_ITEMS);
    return stored ? JSON.parse(stored) : getDefaultActionItems();
  } catch (error) {
    console.error('Error getting action items:', error);
    return getDefaultActionItems();
  }
};

export const saveActionItems = (items) => {
  try {
    localStorage.setItem(STORAGE_KEYS.ACTION_ITEMS, JSON.stringify(items));
    return true;
  } catch (error) {
    console.error('Error saving action items:', error);
    return false;
  }
};

export const addActionItem = (item) => {
  const items = getActionItems();
  const newItem = {
    id: Date.now().toString(),
    ...item,
    completed: false,
    createdAt: new Date().toISOString()
  };
  items.push(newItem);
  saveActionItems(items);
  return items;
};

export const toggleActionItem = (itemId) => {
  const items = getActionItems();
  const item = items.find(i => i.id === itemId);
  if (item) {
    item.completed = !item.completed;
    item.completedAt = item.completed ? new Date().toISOString() : null;
    saveActionItems(items);
  }
  return items;
};

export const deleteActionItem = (itemId) => {
  const items = getActionItems();
  const filtered = items.filter(i => i.id !== itemId);
  saveActionItems(filtered);
  return filtered;
};

export const getDefaultActionItems = () => {
  return [];
};
