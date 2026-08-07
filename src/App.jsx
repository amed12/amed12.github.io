import { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Link, useLocation } from 'react-router-dom';
import { Settings } from 'lucide-react';
import PortfolioPage from './pages/PortfolioPage';
import CVPage from './pages/CVPage';
import SettingsPage from './pages/SettingsPage';
import AdminPanel from './components/Admin/AdminPanel';
import AdminGate, { isAdminUnlocked } from './components/Admin/AdminGate';
import UnpublishedBanner from './components/Admin/UnpublishedBanner';
import { getData, hasUnpublishedChanges, resetData } from './utils/dataManager';

function AppContent({ data, showAdmin, setShowAdmin, handleDataChange, hasDraft, onDiscardDraft }) {
  const location = useLocation();
  const isAdminPath = location.pathname === '/admin';
  const [unlocked, setUnlocked] = useState(isAdminUnlocked());

  return (
    <div className="relative">
      {hasDraft && <UnpublishedBanner onDiscard={onDiscardDraft} />}

      {/* Admin Passphrase Gate - Only show on /admin path until unlocked */}
      {isAdminPath && !unlocked && <AdminGate onUnlock={() => setUnlocked(true)} />}

      {/* Admin Button - Only show on /admin path once unlocked */}
      {isAdminPath && unlocked && (
        <button
          onClick={() => setShowAdmin(true)}
          className="fixed bottom-6 right-6 z-40 bg-primary-600 hover:bg-primary-700 text-white p-4 rounded-full shadow-lg transition-all hover:scale-110"
          title="Open Admin Panel"
        >
          <Settings className="w-6 h-6" />
        </button>
      )}

      {/* Main Content */}
      <Routes>
        <Route path="/" element={<PortfolioPage data={data} />} />
        <Route path="/cv" element={<CVPage data={data} />} />
        <Route path="/settings" element={<SettingsPage data={data} />} />
        <Route path="/admin" element={<PortfolioPage data={data} />} />
      </Routes>

      {/* Admin Panel Modal */}
      {showAdmin && unlocked && (
        <AdminPanel
          data={data}
          onDataChange={handleDataChange}
          onClose={() => setShowAdmin(false)}
        />
      )}
    </div>
  );
}

function App() {
  const [data, setData] = useState(null);
  const [showAdmin, setShowAdmin] = useState(false);
  const [loading, setLoading] = useState(true);
  const [hasDraft, setHasDraft] = useState(false);

  useEffect(() => {
    loadPortfolioData();
  }, []);

  const loadPortfolioData = async () => {
    setLoading(true);
    const portfolioData = await getData();
    setData(portfolioData);
    setHasDraft(hasUnpublishedChanges());
    setLoading(false);
  };

  const handleDataChange = (newData) => {
    setData(newData);
    setHasDraft(hasUnpublishedChanges());
  };

  const handleDiscardDraft = async () => {
    const originalData = await resetData();
    setData(originalData);
    setHasDraft(false);
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50">
        <div className="text-center">
          <div className="animate-spin rounded-full h-16 w-16 border-b-2 border-primary-600 mx-auto mb-4"></div>
          <p className="text-gray-600 text-lg">Loading portfolio...</p>
        </div>
      </div>
    );
  }

  return (
    <Router basename={import.meta.env.BASE_URL}>
      <AppContent
        data={data}
        showAdmin={showAdmin}
        setShowAdmin={setShowAdmin}
        handleDataChange={handleDataChange}
        hasDraft={hasDraft}
        onDiscardDraft={handleDiscardDraft}
      />
    </Router>
  );
}

export default App;
