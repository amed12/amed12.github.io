import { Quote } from 'lucide-react';

const Testimonials = ({ testimonials }) => {
  if (!testimonials || testimonials.length === 0) return null;

  return (
    <section className="py-16 bg-white">
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold mb-12 text-center">Testimonials</h2>
        <div className="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
          {testimonials.map((testimonial) => (
            <div key={testimonial.id} className="card hover:shadow-lg transition-shadow relative">
              <Quote className="w-10 h-10 text-primary-200 absolute top-4 right-4" />
              <div className="relative z-10">
                <p className="text-gray-700 italic mb-6">"{testimonial.message}"</p>
                <div>
                  <p className="font-bold text-gray-900">{testimonial.name}</p>
                  <p className="text-sm text-primary-600">{testimonial.position}</p>
                  {testimonial.project && (
                    <p className="text-sm text-gray-500 mt-1">Project: {testimonial.project}</p>
                  )}
                  {testimonial.date && (
                    <p className="text-sm text-gray-400 mt-1">{testimonial.date}</p>
                  )}
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Testimonials;
