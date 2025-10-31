import { useState } from 'react';
import { 
  LayoutDashboard, 
  FileText, 
  Target, 
  Briefcase, 
  TrendingUp,
  BookOpen,
  CheckSquare,
  Calendar,
  Award,
  Github,
  Linkedin,
  MessageSquare,
  Settings as SettingsIcon,
  Menu,
  X
} from 'lucide-react';

// Import dashboard components
import DashboardOverview from '../components/Settings/DashboardOverview';
import CVManager from '../components/Settings/CVManager';
import InterviewPrep from '../components/Settings/InterviewPrep';
import JobTracker from '../components/Settings/JobTracker';
import SkillDevelopment from '../components/Settings/SkillDevelopment';
import LearningResources from '../components/Settings/LearningResources';
import TodoManager from '../components/Settings/TodoManager';
import ApplicationTimeline from '../components/Settings/ApplicationTimeline';
import AchievementsTracker from '../components/Settings/AchievementsTracker';
import NetworkingHub from '../components/Settings/NetworkingHub';
import PortfolioSettings from '../components/Settings/PortfolioSettings';

const SettingsPage = ({ data }) => {
  const [activeTab, setActiveTab] = useState('dashboard');
  const [sidebarOpen, setSidebarOpen] = useState(false);

  const menuItems = [
    {
      id: 'dashboard',
      label: 'Dashboard',
      icon: LayoutDashboard,
      description: 'Overview of your career progress'
    },
    {
      id: 'cv-manager',
      label: 'CV Manager',
      icon: FileText,
      description: 'Optimize and track CV improvements'
    },
    {
      id: 'interview-prep',
      label: 'Interview Prep',
      icon: Target,
      description: 'Practice questions and strategies'
    },
    {
      id: 'job-tracker',
      label: 'Job Tracker',
      icon: Briefcase,
      description: 'Track applications and follow-ups'
    },
    {
      id: 'skill-development',
      label: 'Skill Development',
      icon: TrendingUp,
      description: 'Track learning progress'
    },
    {
      id: 'learning-resources',
      label: 'Learning Hub',
      icon: BookOpen,
      description: 'Courses, tutorials, and resources'
    },
    {
      id: 'todo-manager',
      label: 'Action Items',
      icon: CheckSquare,
      description: 'Weekly goals and tasks'
    },
    {
      id: 'timeline',
      label: 'Timeline',
      icon: Calendar,
      description: 'Application timeline and milestones'
    },
    {
      id: 'achievements',
      label: 'Achievements',
      icon: Award,
      description: 'Track wins and metrics'
    },
    {
      id: 'networking',
      label: 'Networking',
      icon: MessageSquare,
      description: 'LinkedIn, GitHub, connections'
    },
    {
      id: 'settings',
      label: 'Portfolio Settings',
      icon: SettingsIcon,
      description: 'Edit portfolio content'
    }
  ];

  const renderContent = () => {
    switch (activeTab) {
      case 'dashboard':
        return <DashboardOverview data={data} />;
      case 'cv-manager':
        return <CVManager data={data} />;
      case 'interview-prep':
        return <InterviewPrep data={data} />;
      case 'job-tracker':
        return <JobTracker data={data} />;
      case 'skill-development':
        return <SkillDevelopment data={data} />;
      case 'learning-resources':
        return <LearningResources data={data} />;
      case 'todo-manager':
        return <TodoManager data={data} />;
      case 'timeline':
        return <ApplicationTimeline data={data} />;
      case 'achievements':
        return <AchievementsTracker data={data} />;
      case 'networking':
        return <NetworkingHub data={data} />;
      case 'settings':
        return <PortfolioSettings data={data} />;
      default:
        return <DashboardOverview data={data} />;
    }
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Mobile Header */}
      <div className="lg:hidden fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-40">
        <div className="flex items-center justify-between p-4">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
              <LayoutDashboard className="w-5 h-5 text-white" />
            </div>
            <div>
              <h1 className="text-lg font-bold text-gray-900">Career Hub</h1>
              <p className="text-xs text-gray-500">
                {menuItems.find(item => item.id === activeTab)?.label}
              </p>
            </div>
          </div>
          <button
            onClick={() => setSidebarOpen(!sidebarOpen)}
            className="p-2 rounded-lg hover:bg-gray-100 transition-colors"
          >
            {sidebarOpen ? (
              <X className="w-6 h-6 text-gray-600" />
            ) : (
              <Menu className="w-6 h-6 text-gray-600" />
            )}
          </button>
        </div>
      </div>

      {/* Overlay for mobile */}
      {sidebarOpen && (
        <div
          className="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
          onClick={() => setSidebarOpen(false)}
        />
      )}

      <div className="flex pt-16 lg:pt-0">
        {/* Sidebar */}
        <aside className={`
          w-72 bg-white border-r border-gray-200 h-screen overflow-y-auto z-50
          fixed left-0 top-0 lg:top-0 transition-transform duration-300 ease-in-out
          ${sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'}
        `}>
          {/* Header - Desktop only */}
          <div className="hidden lg:block p-6 border-b border-gray-200">
            <div className="flex items-center gap-3">
              <div className="w-12 h-12 bg-primary-600 rounded-lg flex items-center justify-center">
                <LayoutDashboard className="w-6 h-6 text-white" />
              </div>
              <div>
                <h1 className="text-xl font-bold text-gray-900">Career Hub</h1>
                <p className="text-sm text-gray-500">Job Seeking Dashboard</p>
              </div>
            </div>
          </div>

          {/* Mobile Header inside sidebar */}
          <div className="lg:hidden p-4 border-b border-gray-200 mt-16">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
                <LayoutDashboard className="w-5 h-5 text-white" />
              </div>
              <div>
                <h1 className="text-lg font-bold text-gray-900">Career Hub</h1>
                <p className="text-xs text-gray-500">Job Seeking Dashboard</p>
              </div>
            </div>
          </div>

          {/* Navigation */}
          <nav className="p-4">
            <div className="space-y-1">
              {menuItems.map((item) => {
                const Icon = item.icon;
                const isActive = activeTab === item.id;
                
                return (
                  <button
                    key={item.id}
                    onClick={() => {
                      setActiveTab(item.id);
                      setSidebarOpen(false); // Close sidebar on mobile after selection
                    }}
                    className={`w-full flex items-start gap-3 px-4 py-3 rounded-lg transition-all ${
                      isActive
                        ? 'bg-primary-50 text-primary-700 border border-primary-200'
                        : 'text-gray-700 hover:bg-gray-50'
                    }`}
                  >
                    <Icon className={`w-5 h-5 mt-0.5 flex-shrink-0 ${
                      isActive ? 'text-primary-600' : 'text-gray-400'
                    }`} />
                    <div className="text-left flex-1">
                      <div className={`font-medium text-sm ${
                        isActive ? 'text-primary-700' : 'text-gray-900'
                      }`}>
                        {item.label}
                      </div>
                      <div className="text-xs text-gray-500 mt-0.5">
                        {item.description}
                      </div>
                    </div>
                  </button>
                );
              })}
            </div>
          </nav>

          {/* Quick Stats */}
          <div className="p-4 border-t border-gray-200 mt-4">
            <div className="bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg p-4">
              <div className="text-sm font-medium text-primary-900 mb-2">
                Quick Stats
              </div>
              <div className="space-y-2 text-xs">
                <div className="flex justify-between">
                  <span className="text-primary-700">CV Match Score</span>
                  <span className="font-bold text-primary-900">86%</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-primary-700">Applications</span>
                  <span className="font-bold text-primary-900">0/5</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-primary-700">TODOs Done</span>
                  <span className="font-bold text-primary-900">0/31</span>
                </div>
              </div>
            </div>
          </div>
        </aside>

        {/* Main Content */}
        <main className="w-full lg:ml-72 p-4 sm:p-6 lg:p-8">
          {renderContent()}
        </main>
      </div>
    </div>
  );
};

export default SettingsPage;
