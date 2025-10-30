import { useState, useEffect } from 'react';
import { 
  Briefcase, 
  Clock, 
  CheckCircle, 
  XCircle, 
  Calendar,
  Edit,
  Save,
  X
} from 'lucide-react';
import { getApplications, updateApplication, getStats, formatDate } from '../../utils/storageManager';

const JobTracker = ({ data }) => {
  const [applications, setApplications] = useState(getApplications());
  const [stats, setStats] = useState(getStats());
  const [editingId, setEditingId] = useState(null);
  const [editData, setEditData] = useState({});

  useEffect(() => {
    setStats(getStats());
  }, [applications]);

  const handleStatusChange = (companyId, newStatus) => {
    const updated = updateApplication(companyId, { status: newStatus });
    setApplications(updated);
  };

  const handleDateChange = (companyId, field, date) => {
    const updated = updateApplication(companyId, { [field]: date });
    setApplications(updated);
  };

  const handleNotesChange = (companyId, notes) => {
    const updated = updateApplication(companyId, { notes });
    setApplications(updated);
  };

  const startEdit = (companyId) => {
    setEditingId(companyId);
    setEditData({ ...applications[companyId] });
  };

  const saveEdit = () => {
    const updated = updateApplication(editingId, editData);
    setApplications(updated);
    setEditingId(null);
  };

  const cancelEdit = () => {
    setEditingId(null);
    setEditData({});
  };

  const statusColors = {
    'not-applied': 'bg-gray-100 text-gray-700',
    'applied': 'bg-blue-100 text-blue-700',
    'interview': 'bg-purple-100 text-purple-700',
    'offer': 'bg-green-100 text-green-700',
    'rejected': 'bg-red-100 text-red-700'
  };

  const statusOptions = ['not-applied', 'applied', 'interview', 'offer', 'rejected'];

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-3xl font-bold text-gray-900">Job Application Tracker</h1>
        <p className="text-gray-600 mt-2">Track your applications and follow-ups</p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">{stats.applications.applied}</div>
          <div className="text-sm text-gray-600 mt-1">Applied</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">{stats.applications.interview}</div>
          <div className="text-sm text-gray-600 mt-1">Interviews</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">{stats.applications.offer}</div>
          <div className="text-sm text-gray-600 mt-1">Offers</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">{stats.applications.total}</div>
          <div className="text-sm text-gray-600 mt-1">Target Jobs</div>
        </div>
      </div>

      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h2 className="text-xl font-bold text-gray-900 mb-4">Target Companies</h2>
        <div className="space-y-3">
          {Object.entries(applications).map(([companyId, job]) => (
            <div key={companyId}>
              {editingId === companyId ? (
                // Edit Mode
                <div className="p-4 border-2 border-primary-300 rounded-lg bg-primary-50 space-y-4">
                  <div className="flex items-start justify-between">
                    <div className="flex-1">
                      <h3 className="font-semibold text-gray-900">{job.company}</h3>
                      <p className="text-sm text-gray-600 mt-1">{job.position}</p>
                    </div>
                    <div className="flex gap-2">
                      <button
                        onClick={saveEdit}
                        className="p-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                        title="Save"
                      >
                        <Save className="w-4 h-4" />
                      </button>
                      <button
                        onClick={cancelEdit}
                        className="p-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition-colors"
                        title="Cancel"
                      >
                        <X className="w-4 h-4" />
                      </button>
                    </div>
                  </div>

                  <div className="space-y-3">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Status</label>
                      <select
                        value={editData.status}
                        onChange={(e) => setEditData({ ...editData, status: e.target.value })}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                      >
                        {statusOptions.map(status => (
                          <option key={status} value={status}>
                            {status.replace('-', ' ')}
                          </option>
                        ))}
                      </select>
                    </div>

                    <div className="grid grid-cols-2 gap-3">
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">Applied Date</label>
                        <input
                          type="date"
                          value={editData.appliedDate || ''}
                          onChange={(e) => setEditData({ ...editData, appliedDate: e.target.value })}
                          className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        />
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">Interview Date</label>
                        <input
                          type="date"
                          value={editData.interviewDate || ''}
                          onChange={(e) => setEditData({ ...editData, interviewDate: e.target.value })}
                          className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        />
                      </div>
                    </div>

                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Follow-up Date</label>
                      <input
                        type="date"
                        value={editData.followUpDate || ''}
                        onChange={(e) => setEditData({ ...editData, followUpDate: e.target.value })}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                      />
                    </div>

                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                      <textarea
                        value={editData.notes || ''}
                        onChange={(e) => setEditData({ ...editData, notes: e.target.value })}
                        placeholder="Add any notes about this application..."
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        rows="3"
                      />
                    </div>
                  </div>
                </div>
              ) : (
                // View Mode
                <div className="p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors">
                  <div className="flex items-start justify-between">
                    <div className="flex-1">
                      <div className="flex items-center gap-3">
                        <h3 className="font-semibold text-gray-900">{job.company}</h3>
                        <span className={`px-2 py-1 rounded-full text-xs font-medium ${statusColors[job.status]}`}>
                          {job.status.replace('-', ' ')}
                        </span>
                        <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                          job.priority === 'high' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'
                        }`}>
                          {job.priority} priority
                        </span>
                      </div>
                      <p className="text-sm text-gray-600 mt-1">{job.position}</p>

                      {/* Dates and Notes */}
                      <div className="mt-3 space-y-1 text-xs text-gray-600">
                        {job.appliedDate && (
                          <div className="flex items-center gap-2">
                            <Calendar className="w-3 h-3" />
                            Applied: {formatDate(job.appliedDate)}
                          </div>
                        )}
                        {job.interviewDate && (
                          <div className="flex items-center gap-2">
                            <Clock className="w-3 h-3" />
                            Interview: {formatDate(job.interviewDate)}
                          </div>
                        )}
                        {job.notes && (
                          <div className="mt-2 p-2 bg-gray-50 rounded text-gray-700">
                            {job.notes}
                          </div>
                        )}
                      </div>
                    </div>

                    <div className="flex items-start gap-3 ml-4">
                      <div className="text-right">
                        <div className="text-xl font-bold text-gray-900">{job.match}%</div>
                        <div className="text-xs text-gray-500">match</div>
                      </div>
                      <button
                        onClick={() => startEdit(companyId)}
                        className="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
                        title="Edit"
                      >
                        <Edit className="w-4 h-4" />
                      </button>
                    </div>
                  </div>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default JobTracker;
