const Footer = ({ profile }) => {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="bg-gray-900 text-white py-8">
      <div className="container mx-auto px-4 text-center">
        <p className="text-gray-400">
          © {currentYear} {profile?.name || 'Portfolio'}. All Rights Reserved.
        </p>
      </div>
    </footer>
  );
};

export default Footer;
