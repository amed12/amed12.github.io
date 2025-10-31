import { useState } from 'react';
import { Linkedin, Github, TrendingUp, Users, Eye, Star } from 'lucide-react';
import { getNetworking, updateNetworkingMetric } from '../../utils/storageManager';

const NetworkingHub = () => {
  const [networking, setNetworking] = useState(getNetworking());
  const [editingPlatform, setEditingPlatform] = useState(null);
  const [editData, setEditData] = useState({});

  const handleEdit = (platform) => {
    setEditingPlatform(platform);
    setEditData({ ...networking[platform] });
  };

  const handleSave = (platform) => {
    Object.entries(editData).forEach(([metric, value]) => {
      if (metric !== 'platform' && metric !== 'lastUpdated') {
        updateNetworkingMetric(platform, metric, parseInt(value) || 0);
      }
    });
    setNetworking(getNetworking());
    setEditingPlatform(null);
  };

  const platforms = {
    linkedin: {
      name: 'LinkedIn',
      icon: Linkedin,
      color: 'bg-blue-600',
      metrics: [
        { key: 'connections', label: 'Connections', icon: Users },
        { key: 'profileViews', label: 'Profile Views', icon: Eye },
        { key: 'postEngagement', label: 'Post Engagement', icon: TrendingUp },
        { key: 'recommendationsReceived', label: 'Recommendations Received', icon: Star },
        { key: 'recommendationsGiven', label: 'Recommendations Given', icon: Star }
      ]
    },
    github: {
      name: 'GitHub',
      icon: Github,
      color: 'bg-gray-800',
      metrics: [
        { key: 'followers', label: 'Followers', icon: Users },
        { key: 'contributions', label: 'Contributions (this year)', icon: TrendingUp },
        { key: 'stars', label: 'Total Stars', icon: Star },
        { key: 'repositories', label: 'Public Repositories', icon: Github }
      ]
    }
  };

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-3xl font-bold text-gray-900">Networking Hub</h1>
        <p className="text-gray-600 mt-2">Track your professional network growth</p>
      </div>

      {Object.entries(platforms).map(([platformKey, platform]) => {
        const data = networking[platformKey];
        const Icon = platform.icon;
        const isEditing = editingPlatform === platformKey;

        return (
          <div key={platformKey} className="bg-white rounded-xl p-6 border border-gray-200">
            <div className="flex items-center justify-between mb-6">
              <div className="flex items-center gap-3">
                <div className={`p-3 rounded-lg ${platform.color} text-white`}>
                  <Icon className="w-6 h-6" />
                </div>
                <div>
                  <h2 className="text-xl font-bold text-gray-900">{platform.name}</h2>
                  {data.lastUpdated && (
                    <p className="text-xs text-gray-500">
                      Last updated: {new Date(data.lastUpdated).toLocaleDateString()}
                    </p>
                  )}
                </div>
              </div>
              {!isEditing ? (
                <button
                  onClick={() => handleEdit(platformKey)}
                  className="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
                >
                  Update Metrics
                </button>
              ) : (
                <div className="flex gap-2">
                  <button
                    onClick={() => handleSave(platformKey)}
                    className="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
                  >
                    Save
                  </button>
                  <button
                    onClick={() => setEditingPlatform(null)}
                    className="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
                  >
                    Cancel
                  </button>
                </div>
              )}
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              {platform.metrics.map(metric => {
                const MetricIcon = metric.icon;
                const value = isEditing ? editData[metric.key] : data[metric.key];

                return (
                  <div key={metric.key} className="p-4 border border-gray-200 rounded-lg">
                    <div className="flex items-center gap-2 mb-2">
                      <MetricIcon className="w-4 h-4 text-gray-400" />
                      <span className="text-sm text-gray-600">{metric.label}</span>
                    </div>
                    {isEditing ? (
                      <input
                        type="number"
                        value={value}
                        onChange={(e) => setEditData({ ...editData, [metric.key]: e.target.value })}
                        className="w-full text-2xl font-bold text-gray-900 border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                      />
                    ) : (
                      <div className="text-2xl font-bold text-gray-900">{value || 0}</div>
                    )}
                  </div>
                );
              })}
            </div>
          </div>
        );
      })}

      {/* Tips */}
      <div className="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border border-primary-200">
        <h2 className="text-xl font-bold text-primary-900 mb-4">Networking Tips</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-primary-800">
          <div className="flex items-start gap-2">
            <Linkedin className="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0" />
            <div>
              <div className="font-semibold">LinkedIn Strategy</div>
              <ul className="mt-1 space-y-1 text-primary-700">
                <li>• Post 2-3 times per week about your learning</li>
                <li>• Request recommendations from colleagues</li>
                <li>• Connect with recruiters at target companies</li>
                <li>• Engage with posts in your field</li>
              </ul>
            </div>
          </div>
          <div className="flex items-start gap-2">
            <Github className="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0" />
            <div>
              <div className="font-semibold">GitHub Strategy</div>
              <ul className="mt-1 space-y-1 text-primary-700">
                <li>• Contribute to open source projects</li>
                <li>• Maintain consistent commit history</li>
                <li>• Showcase your best projects with READMEs</li>
                <li>• Star and follow relevant repositories</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      {/* Quick Links */}
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h2 className="text-xl font-bold text-gray-900 mb-4">Quick Links</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
          <a
            href="https://www.linkedin.com/in/achmad-fathullah/"
            target="_blank"
            rel="noopener noreferrer"
            className="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all"
          >
            <Linkedin className="w-5 h-5 text-blue-600" />
            <span className="font-medium text-gray-900">View LinkedIn Profile</span>
          </a>
          <a
            href="https://github.com/amed12"
            target="_blank"
            rel="noopener noreferrer"
            className="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition-all"
          >
            <Github className="w-5 h-5 text-gray-800" />
            <span className="font-medium text-gray-900">View GitHub Profile</span>
          </a>
        </div>
      </div>
    </div>
  );
};

export default NetworkingHub;
