import AdminPanel from '../Admin/AdminPanel';

const PortfolioSettings = ({ data }) => {
  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-3xl font-bold text-gray-900">Portfolio Settings</h1>
        <p className="text-gray-600 mt-2">Edit your portfolio content</p>
      </div>
      <div className="bg-white rounded-xl p-6 border border-gray-200">
        <p className="text-gray-600">Use the admin panel to edit your portfolio content</p>
      </div>
    </div>
  );
};

export default PortfolioSettings;
