import { useState } from 'react';
import { Award, Plus, TrendingUp, Target, Calendar } from 'lucide-react';
import { getAchievements, addAchievement, formatDate } from '../../utils/storageManager';

const AchievementsTracker = () => {
  const [achievements, setAchievements] = useState(getAchievements());
  const [showAddForm, setShowAddForm] = useState(false);
  const [newAchievement, setNewAchievement] = useState({
    title: '',
    description: '',
    category: 'skill',
    metric: '',
    date: new Date().toISOString().split('T')[0]
  });

  const handleAdd = () => {
    if (!newAchievement.title.trim()) return;
    const added = addAchievement(newAchievement);
    setAchievements(added);
    setNewAchievement({ title: '', description: '', category: 'skill', metric: '', date: new Date().toISOString().split('T')[0] });
    setShowAddForm(false);
  };

  const categories = {
    skill: { label: 'Skill Learned', color: 'bg-blue-100 text-blue-700', icon: TrendingUp },
    application: { label: 'Application', color: 'bg-purple-100 text-purple-700', icon: Target },
    project: { label: 'Project', color: 'bg-green-100 text-green-700', icon: Award },
    milestone: { label: 'Milestone', color: 'bg-yellow-100 text-yellow-700', icon: Award }
  };

  const groupedByMonth = achievements.reduce((acc, achievement) => {
    const month = new Date(achievement.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
    if (!acc[month]) acc[month] = [];
    acc[month].push(achievement);
    return acc;
  }, {});

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold text-gray-900">Achievements Tracker</h1>
          <p className="text-gray-600 mt-2">Celebrate your wins and track progress</p>
        </div>
        <button
          onClick={() => setShowAddForm(!showAddForm)}
          className="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors flex items-center gap-2"
        >
          <Plus className="w-5 h-5" />
          Add Achievement
        </button>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        {Object.entries(categories).map(([key, cat]) => {
          const count = achievements.filter(a => a.category === key).length;
          const Icon = cat.icon;
          return (
            <div key={key} className="bg-white rounded-xl p-6 border border-gray-200">
              <div className="flex items-center justify-between mb-2">
                <span className="text-gray-600">{cat.label}</span>
                <Icon className="w-5 h-5 text-gray-400" />
              </div>
              <div className="text-3xl font-bold text-gray-900">{count}</div>
            </div>
          );
        })}
      </div>

      {showAddForm && (
        <div className="bg-white rounded-xl p-6 border-2 border-primary-300">
          <h3 className="text-lg font-bold text-gray-900 mb-4">Add New Achievement</h3>
          <div className="space-y-4">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Title *</label>
              <input
                type="text"
                value={newAchievement.title}
                onChange={(e) => setNewAchievement({ ...newAchievement, title: e.target.value })}
                placeholder="e.g., Completed UI Automator course"
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Description</label>
              <textarea
                value={newAchievement.description}
                onChange={(e) => setNewAchievement({ ...newAchievement, description: e.target.value })}
                placeholder="Details about this achievement..."
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                rows="3"
              />
            </div>
            <div className="grid grid-cols-3 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select
                  value={newAchievement.category}
                  onChange={(e) => setNewAchievement({ ...newAchievement, category: e.target.value })}
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
                  {Object.entries(categories).map(([key, cat]) => (
                    <option key={key} value={key}>{cat.label}</option>
                  ))}
                </select>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Metric (optional)</label>
                <input
                  type="text"
                  value={newAchievement.metric}
                  onChange={(e) => setNewAchievement({ ...newAchievement, metric: e.target.value })}
                  placeholder="e.g., 95% score"
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input
                  type="date"
                  value={newAchievement.date}
                  onChange={(e) => setNewAchievement({ ...newAchievement, date: e.target.value })}
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                />
              </div>
            </div>
            <div className="flex gap-3">
              <button
                onClick={handleAdd}
                className="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
              >
                Add Achievement
              </button>
              <button
                onClick={() => setShowAddForm(false)}
                className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
              >
                Cancel
              </button>
            </div>
          </div>
        </div>
      )}

      {Object.keys(groupedByMonth).length === 0 ? (
        <div className="bg-white rounded-xl p-12 border border-gray-200 text-center">
          <Award className="w-16 h-16 text-gray-300 mx-auto mb-4" />
          <h3 className="text-lg font-semibold text-gray-900 mb-2">No Achievements Yet</h3>
          <p className="text-gray-600">Start tracking your wins and milestones!</p>
        </div>
      ) : (
        Object.entries(groupedByMonth).reverse().map(([month, items]) => (
          <div key={month} className="bg-white rounded-xl p-6 border border-gray-200">
            <h2 className="text-xl font-bold text-gray-900 mb-4">{month}</h2>
            <div className="space-y-3">
              {items.map(achievement => {
                const cat = categories[achievement.category];
                const Icon = cat.icon;
                return (
                  <div key={achievement.id} className="p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors">
                    <div className="flex items-start gap-4">
                      <div className={`p-3 rounded-lg ${cat.color}`}>
                        <Icon className="w-5 h-5" />
                      </div>
                      <div className="flex-1">
                        <div className="flex items-start justify-between">
                          <div>
                            <h3 className="font-semibold text-gray-900">{achievement.title}</h3>
                            {achievement.description && (
                              <p className="text-sm text-gray-600 mt-1">{achievement.description}</p>
                            )}
                            <div className="flex items-center gap-3 mt-2">
                              <span className={`px-2 py-1 rounded-full text-xs font-medium ${cat.color}`}>
                                {cat.label}
                              </span>
                              {achievement.metric && (
                                <span className="text-xs text-gray-600">📊 {achievement.metric}</span>
                              )}
                              <span className="text-xs text-gray-500 flex items-center gap-1">
                                <Calendar className="w-3 h-3" />
                                {formatDate(achievement.date)}
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          </div>
        ))
      )}
    </div>
  );
};

export default AchievementsTracker;
