const About = ({ bio }) => {
  if (!bio) return null;

  return (
    <section className="py-16 bg-white">
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold mb-8 text-center">About Me</h2>
        <div className="max-w-3xl mx-auto">
          <p className="text-lg text-gray-700 leading-relaxed">{bio}</p>
        </div>
      </div>
    </section>
  );
};

export default About;
