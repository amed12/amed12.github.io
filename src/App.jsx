import { useState, useEffect, lazy, Suspense } from 'react';
import { BrowserRouter as Router, Routes, Route, useLocation } from 'react-router-dom';
import { Settings } from 'lucide-react';
import PortfolioPage from './pages/PortfolioPage';
import AdminGate from './components/Admin/AdminGate';
import { isAdminUnlocked } from './utils/adminSession';
import UnpublishedBanner from './components/Admin/UnpublishedBanner';
import { getData, hasUnpublishedChanges, resetData } from './utils/dataManager';

// CV/Share pull in jsPDF + html2canvas and Admin is owner-only, so they are
// split out of the main bundle that every visitor downloads.
const CVPage = lazy(() => import('./pages/CVPage'));
const SharePage = lazy(() => import('./pages/SharePage'));
const AdminPanel = lazy(() => import('./components/Admin/AdminPanel'));

function Spinner({ label }) {
  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50">
      <div className="text-center">
        <div className="animate-spin rounded-full h-16 w-16 border-b-2 border-primary-600 mx-auto mb-4"></div>
        <p className="text-gray-600 text-lg">{label}</p>
      </div>
    </div>
  );
}

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
      <Suspense fallback={<Spinner label="Loading..." />}>
        <Routes>
          <Route path="/" element={<PortfolioPage data={data} />} />
          <Route path="/cv" element={<CVPage data={data} />} />
          <Route path="/share" element={<SharePage data={data} />} />
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
      </Suspense>
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
    return <Spinner label="Loading portfolio..." />;
  }

  // getData() resolves to null when data.json cannot be fetched; every page
  // assumes data is present, so stop here instead of crashing.
  if (!data) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div className="text-center">
          <p className="text-gray-700 text-lg mb-4">Portfolio data could not be loaded.</p>
          <button
            onClick={loadPortfolioData}
            className="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg"
          >
            Try again
          </button>
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
