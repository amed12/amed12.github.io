import { Quote, ChevronLeft, ChevronRight } from 'lucide-react';
import { useState } from 'react';

const Testimonials = ({ testimonials }) => {
  const [currentIndex, setCurrentIndex] = useState(0);

  if (!testimonials || testimonials.length === 0) return null;

  const itemsPerSlide = 2;
  const totalSlides = Math.ceil(testimonials.length / itemsPerSlide);

  const handlePrev = () => {
    setCurrentIndex((prev) => (prev === 0 ? totalSlides - 1 : prev - 1));
  };

  const handleNext = () => {
    setCurrentIndex((prev) => (prev === totalSlides - 1 ? 0 : prev + 1));
  };

  const startIndex = currentIndex * itemsPerSlide;
  const visibleTestimonials = testimonials.slice(startIndex, startIndex + itemsPerSlide);

  return (
    <section className="py-16 bg-white">
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold mb-12 text-center">Testimonials</h2>
        
        <div className="max-w-5xl mx-auto relative">
          {/* Testimonials Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            {visibleTestimonials.map((testimonial) => (
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

          {/* Slider Controls - Only show if more than 2 testimonials */}
          {testimonials.length > itemsPerSlide && (
            <div className="flex justify-center items-center gap-4">
              <button
                onClick={handlePrev}
                className="p-2 rounded-full bg-primary-100 hover:bg-primary-200 text-primary-600 transition-colors"
                aria-label="Previous testimonials"
              >
                <ChevronLeft className="w-6 h-6" />
              </button>

              {/* Slide Indicators */}
              <div className="flex gap-2">
                {Array.from({ length: totalSlides }).map((_, idx) => (
                  <button
                    key={idx}
                    onClick={() => setCurrentIndex(idx)}
                    className={`w-2 h-2 rounded-full transition-colors ${
                      idx === currentIndex ? 'bg-primary-600' : 'bg-primary-200'
                    }`}
                    aria-label={`Go to slide ${idx + 1}`}
                  />
                ))}
              </div>

              <button
                onClick={handleNext}
                className="p-2 rounded-full bg-primary-100 hover:bg-primary-200 text-primary-600 transition-colors"
                aria-label="Next testimonials"
              >
                <ChevronRight className="w-6 h-6" />
              </button>
            </div>
          )}
        </div>
      </div>
    </section>
  );
};

export default Testimonials;
