import { useState, useEffect } from 'react';
import { Plus, CheckCircle, Trash2, Calendar, AlertCircle } from 'lucide-react';
import { getActionItems, addActionItem, toggleActionItem, deleteActionItem, formatDate, getDaysUntil } from '../../utils/storageManager';

const TodoManager = () => {
  const [items, setItems] = useState(getActionItems());
  const [showAddForm, setShowAddForm] = useState(false);
  const [newItem, setNewItem] = useState({
    title: '',
    description: '',
    priority: 'medium',
    dueDate: ''
  });

  const handleAddItem = () => {
    if (!newItem.title.trim()) return;
    
    const added = addActionItem(newItem);
    setItems(added);
    setNewItem({ title: '', description: '', priority: 'medium', dueDate: '' });
    setShowAddForm(false);
  };

  const handleToggle = (itemId) => {
    const updated = toggleActionItem(itemId);
    setItems(updated);
  };

  const handleDelete = (itemId) => {
    if (confirm('Are you sure you want to delete this action item?')) {
      const updated = deleteActionItem(itemId);
      setItems(updated);
    }
  };

  const completedItems = items.filter(i => i.completed);
  const pendingItems = items.filter(i => !i.completed);
  const overdueItems = pendingItems.filter(i => i.dueDate && getDaysUntil(i.dueDate) < 0);
  const todayItems = pendingItems.filter(i => i.dueDate && getDaysUntil(i.dueDate) === 0);

  const getPriorityColor = (priority) => {
    switch (priority) {
      case 'high': return 'bg-red-100 text-red-700 border-red-300';
      case 'medium': return 'bg-yellow-100 text-yellow-700 border-yellow-300';
      case 'low': return 'bg-gray-100 text-gray-700 border-gray-300';
      default: return 'bg-gray-100 text-gray-700 border-gray-300';
    }
  };

  const getDueDateStatus = (dueDate) => {
    if (!dueDate) return null;
    const days = getDaysUntil(dueDate);
    if (days < 0) return { text: `${Math.abs(days)} days overdue`, color: 'text-red-600' };
    if (days === 0) return { text: 'Due today', color: 'text-orange-600' };
    if (days <= 3) return { text: `Due in ${days} days`, color: 'text-yellow-600' };
    return { text: `Due in ${days} days`, color: 'text-gray-600' };
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold text-gray-900">Action Items</h1>
          <p className="text-gray-600 mt-2">Manage your daily and weekly tasks</p>
        </div>
        <button
          onClick={() => setShowAddForm(!showAddForm)}
          className="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors flex items-center gap-2"
        >
          <Plus className="w-5 h-5" />
          Add Item
        </button>
      </div>

      {/* Stats */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">{pendingItems.length}</div>
          <div className="text-sm text-gray-600 mt-1">Pending</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-gray-900">{completedItems.length}</div>
          <div className="text-sm text-gray-600 mt-1">Completed</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-red-600">{overdueItems.length}</div>
          <div className="text-sm text-gray-600 mt-1">Overdue</div>
        </div>
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <div className="text-3xl font-bold text-orange-600">{todayItems.length}</div>
          <div className="text-sm text-gray-600 mt-1">Due Today</div>
        </div>
      </div>

      {/* Add Form */}
      {showAddForm && (
        <div className="bg-white rounded-xl p-6 border-2 border-primary-300">
          <h3 className="text-lg font-bold text-gray-900 mb-4">Add New Action Item</h3>
          <div className="space-y-4">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Title *</label>
              <input
                type="text"
                value={newItem.title}
                onChange={(e) => setNewItem({ ...newItem, title: e.target.value })}
                placeholder="e.g., Complete UI Automator tutorial"
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">Description</label>
              <textarea
                value={newItem.description}
                onChange={(e) => setNewItem({ ...newItem, description: e.target.value })}
                placeholder="Add details..."
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                rows="3"
              />
            </div>
            <div className="grid grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                <select
                  value={newItem.priority}
                  onChange={(e) => setNewItem({ ...newItem, priority: e.target.value })}
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
                  <option value="high">High</option>
                  <option value="medium">Medium</option>
                  <option value="low">Low</option>
                </select>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                <input
                  type="date"
                  value={newItem.dueDate}
                  onChange={(e) => setNewItem({ ...newItem, dueDate: e.target.value })}
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                />
              </div>
            </div>
            <div className="flex gap-3">
              <button
                onClick={handleAddItem}
                className="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
              >
                Add Item
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

      {/* Overdue Items */}
      {overdueItems.length > 0 && (
        <div className="bg-red-50 rounded-xl p-6 border border-red-200">
          <div className="flex items-center gap-2 mb-4">
            <AlertCircle className="w-5 h-5 text-red-600" />
            <h2 className="text-xl font-bold text-red-900">Overdue Items</h2>
          </div>
          <div className="space-y-3">
            {overdueItems.map(item => {
              const dueDateStatus = getDueDateStatus(item.dueDate);
              return (
                <div key={item.id} className="bg-white p-4 rounded-lg border border-red-300">
                  <div className="flex items-start gap-3">
                    <input
                      type="checkbox"
                      checked={item.completed}
                      onChange={() => handleToggle(item.id)}
                      className="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 mt-0.5"
                    />
                    <div className="flex-1">
                      <h3 className="font-semibold text-gray-900">{item.title}</h3>
                      {item.description && (
                        <p className="text-sm text-gray-600 mt-1">{item.description}</p>
                      )}
                      <div className="flex items-center gap-3 mt-2">
                        <span className={`px-2 py-1 rounded-full text-xs font-medium border ${getPriorityColor(item.priority)}`}>
                          {item.priority}
                        </span>
                        {dueDateStatus && (
                          <span className={`text-xs font-medium ${dueDateStatus.color}`}>
                            {dueDateStatus.text}
                          </span>
                        )}
                      </div>
                    </div>
                    <button
                      onClick={() => handleDelete(item.id)}
                      className="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                    >
                      <Trash2 className="w-4 h-4" />
                    </button>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      )}

      {/* Pending Items */}
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <h2 className="text-xl font-bold text-gray-900 mb-4">Pending Items</h2>
        {pendingItems.filter(i => !overdueItems.includes(i)).length === 0 ? (
          <p className="text-gray-500 text-center py-8">No pending items. Add one to get started!</p>
        ) : (
          <div className="space-y-3">
            {pendingItems.filter(i => !overdueItems.includes(i)).map(item => {
              const dueDateStatus = getDueDateStatus(item.dueDate);
              return (
                <div key={item.id} className="p-4 border border-gray-200 rounded-lg hover:border-primary-300 transition-colors">
                  <div className="flex items-start gap-3">
                    <input
                      type="checkbox"
                      checked={item.completed}
                      onChange={() => handleToggle(item.id)}
                      className="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 mt-0.5"
                    />
                    <div className="flex-1">
                      <h3 className="font-semibold text-gray-900">{item.title}</h3>
                      {item.description && (
                        <p className="text-sm text-gray-600 mt-1">{item.description}</p>
                      )}
                      <div className="flex items-center gap-3 mt-2">
                        <span className={`px-2 py-1 rounded-full text-xs font-medium border ${getPriorityColor(item.priority)}`}>
                          {item.priority}
                        </span>
                        {dueDateStatus && (
                          <span className={`text-xs font-medium ${dueDateStatus.color} flex items-center gap-1`}>
                            <Calendar className="w-3 h-3" />
                            {dueDateStatus.text}
                          </span>
                        )}
                      </div>
                    </div>
                    <button
                      onClick={() => handleDelete(item.id)}
                      className="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                    >
                      <Trash2 className="w-4 h-4" />
                    </button>
                  </div>
                </div>
              );
            })}
          </div>
        )}
      </div>

      {/* Completed Items */}
      {completedItems.length > 0 && (
        <div className="bg-white rounded-xl p-6 border border-gray-200">
          <h2 className="text-xl font-bold text-gray-900 mb-4">Completed Items</h2>
          <div className="space-y-3">
            {completedItems.map(item => (
              <div key={item.id} className="p-4 bg-green-50 border border-green-200 rounded-lg">
                <div className="flex items-start gap-3">
                  <input
                    type="checkbox"
                    checked={item.completed}
                    onChange={() => handleToggle(item.id)}
                    className="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 mt-0.5"
                  />
                  <div className="flex-1">
                    <h3 className="font-semibold text-gray-700 line-through">{item.title}</h3>
                    {item.description && (
                      <p className="text-sm text-gray-600 mt-1 line-through">{item.description}</p>
                    )}
                    {item.completedAt && (
                      <div className="text-xs text-green-700 mt-2">
                        <CheckCircle className="w-3 h-3 inline mr-1" />
                        Completed {formatDate(item.completedAt)}
                      </div>
                    )}
                  </div>
                  <button
                    onClick={() => handleDelete(item.id)}
                    className="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                  >
                    <Trash2 className="w-4 h-4" />
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  );
};

export default TodoManager;
