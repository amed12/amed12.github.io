import Header from '../components/Portfolio/Header';
import About from '../components/Portfolio/About';
import Skills from '../components/Portfolio/Skills';
import Experience from '../components/Portfolio/Experience';
import Projects from '../components/Portfolio/Projects';
import Education from '../components/Portfolio/Education';
import Certifications from '../components/Portfolio/Certifications';
import Testimonials from '../components/Portfolio/Testimonials';
import Footer from '../components/Portfolio/Footer';

const PortfolioPage = ({ data }) => {
  if (!data) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-16 w-16 border-b-2 border-primary-600 mx-auto mb-4"></div>
          <p className="text-gray-600">Loading portfolio...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen">
      <Header profile={data.profile} />
      <About bio={data.profile?.bio} />
      <Skills skills={data.skills} />
      <Experience experience={data.experience} />
      <Projects projects={data.projects} />
      <Education education={data.education} />
      <Certifications certifications={data.certifications} />
      <Testimonials testimonials={data.testimonials} />
      <Footer profile={data.profile} />
    </div>
  );
};

export default PortfolioPage;
