import { useState, useEffect } from 'react';
import { 
  FileText, 
  CheckCircle, 
  AlertCircle, 
  TrendingUp,
  Download,
  Eye,
  Edit,
  Target,
  RotateCcw
} from 'lucide-react';
import { getTodos, saveTodos, toggleTodo, getStats } from '../../utils/storageManager';

const CVManager = ({ data }) => {
  const [activeSection, setActiveSection] = useState('overview');
  const [todos, setTodos] = useState(getTodos());
  const [stats, setStats] = useState(getStats());
  const cvNotes = data?.cv_improvement_notes || {};

  useEffect(() => {
    setStats(getStats());
  }, [todos]);

  const handleToggleTodo = (experienceId, todoIndex) => {
    const updatedTodos = toggleTodo(experienceId, todoIndex);
    setTodos(updatedTodos);
  };

  const handleResetTodos = () => {
    if (confirm('Are you sure you want to reset all TODOs? This cannot be undone.')) {
      const defaultTodos = getTodos();
      setTodos(defaultTodos);
    }
  };

  const sections = [
    { id: 'overview', label: 'Overview', icon: Eye },
    { id: 'todos', label: 'TODOs', icon: CheckCircle },
    { id: 'improvements', label: 'Improvements', icon: TrendingUp },
    { id: 'match-analysis', label: 'Match Analysis', icon: Target }
  ];

  const experienceTodos = Object.entries(todos).map(([key, exp]) => ({
    id: key,
    experience: exp.experience,
    todos: exp.todos
  }));

  const totalTodos = stats.todos.total;
  const completedTodos = stats.todos.completed;

  const matchScores = cvNotes?.job_application_strategy?.match_scores || {};

  const renderOverview = () => (
    <div className="space-y-6">
      {/* CV Status Card */}
      <div className="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border border-primary-200">
        <div className="flex items-start justify-between">
          <div>
            <h3 className="text-2xl font-bold text-primary-900 mb-2">CV Status: Good</h3>
            <p className="text-primary-700 mb-4">
              Your CV is 86% optimized for target positions. Complete TODOs to reach 95%+
            </p>
            <div className="flex gap-4">
              <button className="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors flex items-center gap-2">
                <Download className="w-4 h-4" />
                Download CV
              </button>
              <button className="px-4 py-2 bg-white text-primary-600 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                <Eye className="w-4 h-4" />
                Preview
              </button>
            </div>
          </div>
          <div className="text-right">
            <div className="text-5xl font-bold text-primary-600">86%</div>
            <div className="text-sm text-primary-700">Match Score</div>
          </div>
        </div>
      </div>

      {/* Progress Stats */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="flex items-center justify-between mb-2">
            <span className="text-gray-600">TODOs Completed</span>
            <CheckCircle className="w-5 h-5 text-green-500" />
          </div>
          <div className="text-3xl font-bold text-gray-900">{completedTodos}/{totalTodos}</div>
          <div className="w-full bg-gray-200 rounded-full h-2 mt-3">
            <div 
              className="bg-green-500 h-2 rounded-full" 
              style={{ width: `${(completedTodos/totalTodos)*100}%` }}
            />
          </div>
        </div>

        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="flex items-center justify-between mb-2">
            <span className="text-gray-600">Skills Added</span>
            <TrendingUp className="w-5 h-5 text-blue-500" />
          </div>
          <div className="text-3xl font-bold text-gray-900">16/20</div>
          <div className="text-sm text-gray-500 mt-1">4 TODO skills to learn</div>
        </div>

        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="flex items-center justify-between mb-2">
            <span className="text-gray-600">Avg Match Score</span>
            <Target className="w-5 h-5 text-purple-500" />
          </div>
          <div className="text-3xl font-bold text-gray-900">86%</div>
          <div className="text-sm text-green-600 mt-1">+18% improvement</div>
        </div>
      </div>

      {/* Quick Actions */}
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h3 className="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          <button className="p-4 border-2 border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 transition-all text-left">
            <div className="flex items-center gap-3">
              <div className="p-2 bg-primary-100 rounded-lg">
                <Edit className="w-5 h-5 text-primary-600" />
              </div>
              <div>
                <div className="font-semibold text-gray-900">Fill Critical TODOs</div>
                <div className="text-sm text-gray-600">Add metrics to current role</div>
              </div>
            </div>
          </button>

          <button className="p-4 border-2 border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 transition-all text-left">
            <div className="flex items-center gap-3">
              <div className="p-2 bg-blue-100 rounded-lg">
                <FileText className="w-5 h-5 text-blue-600" />
              </div>
              <div>
                <div className="font-semibold text-gray-900">Update Experience</div>
                <div className="text-sm text-gray-600">Add specific features built</div>
              </div>
            </div>
          </button>

          <button className="p-4 border-2 border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 transition-all text-left">
            <div className="flex items-center gap-3">
              <div className="p-2 bg-green-100 rounded-lg">
                <TrendingUp className="w-5 h-5 text-green-600" />
              </div>
              <div>
                <div className="font-semibold text-gray-900">Add Skills</div>
                <div className="text-sm text-gray-600">Update technical skills</div>
              </div>
            </div>
          </button>

          <button className="p-4 border-2 border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 transition-all text-left">
            <div className="flex items-center gap-3">
              <div className="p-2 bg-purple-100 rounded-lg">
                <Download className="w-5 h-5 text-purple-600" />
              </div>
              <div>
                <div className="font-semibold text-gray-900">Export CV</div>
                <div className="text-sm text-gray-600">Download as PDF</div>
              </div>
            </div>
          </button>
        </div>
      </div>
    </div>
  );

  const renderTodos = () => (
    <div className="space-y-6">
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <div className="flex items-center justify-between mb-6">
          <div>
            <h3 className="text-xl font-bold text-gray-900">Experience TODOs</h3>
            <p className="text-gray-600 mt-1">Complete these to improve your CV match score</p>
          </div>
          <div className="flex items-center gap-4">
            <div className="text-right">
              <div className="text-2xl font-bold text-gray-900">{completedTodos}/{totalTodos}</div>
              <div className="text-sm text-gray-500">completed</div>
            </div>
            <button
              onClick={handleResetTodos}
              className="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
              title="Reset all TODOs"
            >
              <RotateCcw className="w-5 h-5" />
            </button>
          </div>
        </div>

        <div className="space-y-6">
          {experienceTodos.map((exp) => (
            <div key={exp.id} className="border border-gray-200 rounded-lg p-4">
              <h4 className="font-semibold text-gray-900 mb-3">{exp.experience}</h4>
              <div className="space-y-2">
                {exp.todos.map((todo, todoIndex) => (
                  <label 
                    key={todoIndex}
                    className="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors"
                  >
                    <input
                      type="checkbox"
                      checked={todo.done}
                      onChange={() => handleToggleTodo(exp.id, todoIndex)}
                      className="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 mt-0.5"
                    />
                    <div className="flex-1">
                      <span className={`text-sm ${
                        todo.done ? 'line-through text-gray-400' : 'text-gray-700'
                      }`}>
                        {todo.text}
                      </span>
                      <div className="flex items-center gap-2 mt-1">
                        <span className={`text-xs px-2 py-0.5 rounded-full ${
                          todo.priority === 'high' 
                            ? 'bg-red-100 text-red-700'
                            : todo.priority === 'medium'
                            ? 'bg-yellow-100 text-yellow-700'
                            : 'bg-gray-100 text-gray-700'
                        }`}>
                          {todo.priority} priority
                        </span>
                      </div>
                    </div>
                  </label>
                ))}
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );

  const renderImprovements = () => (
    <div className="space-y-6">
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h3 className="text-xl font-bold text-gray-900 mb-4">Recent Improvements</h3>
        <div className="space-y-4">
          <div className="flex items-start gap-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <CheckCircle className="w-5 h-5 text-green-600 mt-0.5" />
            <div>
              <div className="font-semibold text-gray-900">Enhanced Profile Bio</div>
              <div className="text-sm text-gray-600 mt-1">
                Added 5+ years experience, Apple Academy credential, and technical keywords
              </div>
              <div className="text-xs text-gray-500 mt-2">Impact: +5% match score</div>
            </div>
          </div>

          <div className="flex items-start gap-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <CheckCircle className="w-5 h-5 text-green-600 mt-0.5" />
            <div>
              <div className="font-semibold text-gray-900">Added 16 Technical Skills</div>
              <div className="text-sm text-gray-600 mt-1">
                MVVM, Clean Architecture, BLoC, Testing frameworks, Performance Optimization
              </div>
              <div className="text-xs text-gray-500 mt-2">Impact: +10% match score</div>
            </div>
          </div>

          <div className="flex items-start gap-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <CheckCircle className="w-5 h-5 text-green-600 mt-0.5" />
            <div>
              <div className="font-semibold text-gray-900">Enhanced All Experience Descriptions</div>
              <div className="text-sm text-gray-600 mt-1">
                Added technical depth, specific tools, and professional language
              </div>
              <div className="text-xs text-gray-500 mt-2">Impact: +8% match score</div>
            </div>
          </div>
        </div>
      </div>

      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h3 className="text-xl font-bold text-gray-900 mb-4">Recommended Next Steps</h3>
        <div className="space-y-3">
          {cvNotes?.areas_to_strengthen?.immediate_actions?.map((action, index) => (
            <div key={index} className="flex items-start gap-3 p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors">
              <AlertCircle className="w-5 h-5 text-primary-600 mt-0.5" />
              <div className="text-sm text-gray-700">{action.replace('TODO: ', '')}</div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );

  const renderMatchAnalysis = () => (
    <div className="space-y-6">
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h3 className="text-xl font-bold text-gray-900 mb-4">Job Match Analysis</h3>
        <div className="space-y-4">
          {Object.entries(matchScores).map(([key, value], index) => {
            const score = parseInt(value.split('%')[0]);
            const description = value.split(' - ')[1] || '';
            const companyName = key.replace(/_/g, ' ').split(' ').map(w => 
              w.charAt(0).toUpperCase() + w.slice(1)
            ).join(' ');

            return (
              <div key={index} className="p-4 border border-gray-200 rounded-lg">
                <div className="flex items-center justify-between mb-3">
                  <div>
                    <h4 className="font-semibold text-gray-900">{companyName}</h4>
                    <p className="text-sm text-gray-600 mt-1">{description}</p>
                  </div>
                  <div className="text-right">
                    <div className="text-2xl font-bold text-gray-900">{score}%</div>
                    <div className={`text-xs font-medium ${
                      score >= 90 ? 'text-green-600' : score >= 85 ? 'text-blue-600' : 'text-yellow-600'
                    }`}>
                      {score >= 90 ? 'Ready' : score >= 85 ? 'Good' : 'Needs Work'}
                    </div>
                  </div>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-2">
                  <div 
                    className={`h-2 rounded-full ${
                      score >= 90 ? 'bg-green-500' : score >= 85 ? 'bg-blue-500' : 'bg-yellow-500'
                    }`}
                    style={{ width: `${score}%` }}
                  />
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );

  return (
    <div className="space-y-6">
      {/* Header */}
      <div>
        <h1 className="text-3xl font-bold text-gray-900">CV Manager</h1>
        <p className="text-gray-600 mt-2">
          Optimize your CV and track improvements
        </p>
      </div>

      {/* Tabs */}
      <div className="bg-white rounded-xl border border-gray-200 p-2">
        <div className="flex gap-2">
          {sections.map((section) => {
            const Icon = section.icon;
            return (
              <button
                key={section.id}
                onClick={() => setActiveSection(section.id)}
                className={`flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-lg transition-all ${
                  activeSection === section.id
                    ? 'bg-primary-600 text-white'
                    : 'text-gray-600 hover:bg-gray-50'
                }`}
              >
                <Icon className="w-4 h-4" />
                <span className="font-medium">{section.label}</span>
              </button>
            );
          })}
        </div>
      </div>

      {/* Content */}
      {activeSection === 'overview' && renderOverview()}
      {activeSection === 'todos' && renderTodos()}
      {activeSection === 'improvements' && renderImprovements()}
      {activeSection === 'match-analysis' && renderMatchAnalysis()}
    </div>
  );
};

export default CVManager;
