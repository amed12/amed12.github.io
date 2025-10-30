import { useState, useEffect } from 'react';
import { 
  TrendingUp, 
  Target, 
  CheckCircle, 
  Clock,
  Briefcase,
  FileText,
  Award,
  AlertCircle
} from 'lucide-react';
import { getStats, getApplications, getWeeklyGoals, toggleWeeklyGoal } from '../../utils/storageManager';

const DashboardOverview = ({ data }) => {
  const [stats, setStats] = useState(getStats());
  const [applications, setApplications] = useState(getApplications());
  const [weeklyGoals, setWeeklyGoals] = useState(getWeeklyGoals());
  const cvNotes = data?.cv_improvement_notes || {};

  const matchScores = cvNotes?.job_application_strategy?.match_scores || {};

  const handleToggleGoal = (goalIndex) => {
    const updated = toggleWeeklyGoal(goalIndex);
    setWeeklyGoals(updated);
    setStats(getStats());
  };

  const stats_cards = [
    {
      label: 'CV Match Score',
      value: `${stats.cvMatchScore}%`,
      change: '+18%',
      trend: 'up',
      icon: FileText,
      color: 'primary'
    },
    {
      label: 'Applications',
      value: `${stats.applications.applied}/5`,
      subtitle: 'Ready to apply',
      icon: Briefcase,
      color: 'blue'
    },
    {
      label: 'TODOs Completed',
      value: `${stats.todos.completed}/${stats.todos.total}`,
      subtitle: 'In progress',
      icon: CheckCircle,
      color: 'green'
    },
    {
      label: 'Interviews',
      value: stats.applications.interview,
      subtitle: 'Scheduled',
      icon: TrendingUp,
      color: 'purple'
    }
  ];

  const urgentActions = [
    {
      title: 'Apply to PermataBank',
      description: '90% match - highest priority',
      priority: 'high',
      time: '2 hours',
      status: applications.permatabank?.status
    },
    {
      title: 'Apply to Grab Android',
      description: '90% match - strong fit',
      priority: 'high',
      time: '2 hours',
      status: applications.grab_android?.status
    },
    {
      title: 'Fill CV Metrics',
      description: 'Add quantifiable achievements',
      priority: 'medium',
      time: '2-3 hours'
    },
    {
      title: 'Update LinkedIn',
      description: 'Sync with enhanced CV',
      priority: 'medium',
      time: '1 hour'
    }
  ];

  const jobMatches = Object.entries(matchScores).map(([key, value]) => {
    const score = parseInt(value.split('%')[0]);
    const description = value.split(' - ')[1] || '';
    const companyName = key.replace(/_/g, ' ').split(' ').map(w => 
      w.charAt(0).toUpperCase() + w.slice(1)
    ).join(' ');

    return {
      company: companyName,
      score,
      description,
      status: score >= 90 ? 'ready' : score >= 85 ? 'good' : 'needs-work'
    };
  }).sort((a, b) => b.score - a.score);

  return (
    <div className="space-y-6">
      {/* Header */}
      <div>
        <h1 className="text-3xl font-bold text-gray-900">Career Dashboard</h1>
        <p className="text-gray-600 mt-2">
          Track your job search progress and career development
        </p>
      </div>

      {/* Stats Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats_cards.map((stat, index) => {
          const Icon = stat.icon;
          const colorClasses = {
            primary: 'bg-primary-50 text-primary-600',
            blue: 'bg-blue-50 text-blue-600',
            green: 'bg-green-50 text-green-600',
            purple: 'bg-purple-50 text-purple-600'
          };

          return (
            <div key={index} className="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
              <div className="flex items-start justify-between">
                <div className="flex-1">
                  <p className="text-sm text-gray-600 mb-1">{stat.label}</p>
                  <p className="text-3xl font-bold text-gray-900">{stat.value}</p>
                  {stat.subtitle && (
                    <p className="text-xs text-gray-500 mt-1">{stat.subtitle}</p>
                  )}
                  {stat.change && (
                    <div className="flex items-center gap-1 mt-2">
                      <TrendingUp className="w-4 h-4 text-green-600" />
                      <span className="text-sm text-green-600 font-medium">{stat.change}</span>
                    </div>
                  )}
                </div>
                <div className={`p-3 rounded-lg ${colorClasses[stat.color]}`}>
                  <Icon className="w-6 h-6" />
                </div>
              </div>
            </div>
          );
        })}
      </div>

      {/* Main Content Grid */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Urgent Actions */}
        <div className="lg:col-span-2">
          <div className="bg-white rounded-xl p-6 border border-gray-200">
            <div className="flex items-center justify-between mb-4">
              <h2 className="text-xl font-bold text-gray-900">Urgent Actions</h2>
              <span className="text-sm text-gray-500">This Week</span>
            </div>
            <div className="space-y-3">
              {urgentActions.map((action, index) => (
                <div 
                  key={index}
                  className={`flex items-start gap-4 p-4 rounded-lg border transition-all cursor-pointer ${
                    action.status && action.status !== 'not-applied'
                      ? 'border-green-300 bg-green-50'
                      : 'border-gray-200 hover:border-primary-300 hover:bg-primary-50'
                  }`}
                >
                  <div className={`w-2 h-2 rounded-full mt-2 flex-shrink-0 ${
                    action.priority === 'high' ? 'bg-red-500' : 'bg-yellow-500'
                  }`} />
                  <div className="flex-1">
                    <div className="flex items-start justify-between">
                      <div>
                        <h3 className="font-semibold text-gray-900">{action.title}</h3>
                        <p className="text-sm text-gray-600 mt-1">{action.description}</p>
                        {action.status && action.status !== 'not-applied' && (
                          <p className="text-xs text-green-700 mt-1 font-medium">
                            ✓ {action.status.replace('-', ' ')}
                          </p>
                        )}
                      </div>
                      <span className="text-xs text-gray-500 flex items-center gap-1 whitespace-nowrap ml-4">
                        <Clock className="w-3 h-3" />
                        {action.time}
                      </span>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* Weekly Goals */}
        <div>
          <div className="bg-white rounded-xl p-6 border border-gray-200">
            <h2 className="text-xl font-bold text-gray-900 mb-4">Week 1 Goals</h2>
            <div className="space-y-3">
              {weeklyGoals.map((goal, index) => (
                <label 
                  key={index}
                  className="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors"
                >
                  <input
                    type="checkbox"
                    checked={goal.completed}
                    onChange={() => handleToggleGoal(index)}
                    className="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                  />
                  <span className={`text-sm ${
                    goal.completed ? 'line-through text-gray-400' : 'text-gray-700'
                  }`}>
                    {goal.task}
                  </span>
                </label>
              ))}
            </div>
            <div className="mt-4 pt-4 border-t border-gray-200">
              <div className="flex justify-between text-sm">
                <span className="text-gray-600">Progress</span>
                <span className="font-semibold text-gray-900">
                  {weeklyGoals.filter(g => g.completed).length}/{weeklyGoals.length} ({Math.round((weeklyGoals.filter(g => g.completed).length/weeklyGoals.length)*100)}%)
                </span>
              </div>
              <div className="w-full bg-gray-200 rounded-full h-2 mt-2">
                <div 
                  className="bg-primary-600 h-2 rounded-full" 
                  style={{ width: `${(weeklyGoals.filter(g => g.completed).length/weeklyGoals.length)*100}%` }} 
                />
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Job Match Scores */}
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h2 className="text-xl font-bold text-gray-900 mb-4">Job Match Scores</h2>
        <div className="space-y-4">
          {jobMatches.map((job, index) => (
            <div key={index} className="space-y-2">
              <div className="flex items-center justify-between">
                <div className="flex-1">
                  <div className="flex items-center gap-3">
                    <h3 className="font-semibold text-gray-900">{job.company}</h3>
                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                      job.status === 'ready' 
                        ? 'bg-green-100 text-green-700'
                        : job.status === 'good'
                        ? 'bg-blue-100 text-blue-700'
                        : 'bg-yellow-100 text-yellow-700'
                    }`}>
                      {job.status === 'ready' ? 'Ready to Apply' : job.status === 'good' ? 'Good Match' : 'Needs Work'}
                    </span>
                  </div>
                  <p className="text-sm text-gray-600 mt-1">{job.description}</p>
                </div>
                <div className="text-right ml-4">
                  <div className="text-2xl font-bold text-gray-900">{job.score}%</div>
                  <div className="text-xs text-gray-500">match</div>
                </div>
              </div>
              <div className="w-full bg-gray-200 rounded-full h-2">
                <div 
                  className={`h-2 rounded-full ${
                    job.score >= 90 ? 'bg-green-500' : job.score >= 85 ? 'bg-blue-500' : 'bg-yellow-500'
                  }`}
                  style={{ width: `${job.score}%` }}
                />
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Confidence Boosters */}
      <div className="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border border-primary-200">
        <div className="flex items-start gap-4">
          <div className="p-3 bg-white rounded-lg">
            <Award className="w-6 h-6 text-primary-600" />
          </div>
          <div className="flex-1">
            <h2 className="text-xl font-bold text-primary-900 mb-2">You're Qualified!</h2>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-primary-800">
              <div className="flex items-center gap-2">
                <CheckCircle className="w-4 h-4 text-primary-600" />
                <span>5+ years experience (meets all requirements)</span>
              </div>
              <div className="flex items-center gap-2">
                <CheckCircle className="w-4 h-4 text-primary-600" />
                <span>Multi-platform skills (rare and valuable)</span>
              </div>
              <div className="flex items-center gap-2">
                <CheckCircle className="w-4 h-4 text-primary-600" />
                <span>Apple Academy credential (strong signal)</span>
              </div>
              <div className="flex items-center gap-2">
                <CheckCircle className="w-4 h-4 text-primary-600" />
                <span>86% match is ABOVE industry standard</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DashboardOverview;
