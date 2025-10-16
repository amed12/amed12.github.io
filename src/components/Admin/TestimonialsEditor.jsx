import { Plus, Trash2 } from 'lucide-react';

const TestimonialsEditor = ({ testimonials, onChange }) => {
  const addTestimonial = () => {
    const newTest = {
      id: `test${Date.now()}`,
      name: '',
      position: '',
      project: '',
      message: '',
    };
    onChange([...testimonials, newTest]);
  };

  const removeTestimonial = (id) => {
    onChange(testimonials.filter((test) => test.id !== id));
  };

  const updateTestimonial = (id, field, value) => {
    const updated = testimonials.map((test) =>
      test.id === id ? { ...test, [field]: value } : test
    );
    onChange(updated);
  };

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h2 className="text-2xl font-bold">Testimonials</h2>
        <button onClick={addTestimonial} className="btn-primary flex items-center gap-2">
          <Plus className="w-4 h-4" />
          Add Testimonial
        </button>
      </div>

      <div className="space-y-6">
        {testimonials.map((test) => (
          <div key={test.id} className="card">
            <div className="flex items-start justify-between mb-4">
              <h3 className="text-lg font-semibold">Testimonial Entry</h3>
              <button
                onClick={() => removeTestimonial(test.id)}
                className="text-red-600 hover:text-red-700"
              >
                <Trash2 className="w-5 h-5" />
              </button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input
                  type="text"
                  value={test.name}
                  onChange={(e) => updateTestimonial(test.id, 'name', e.target.value)}
                  className="input-field"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Position</label>
                <input
                  type="text"
                  value={test.position}
                  onChange={(e) => updateTestimonial(test.id, 'position', e.target.value)}
                  className="input-field"
                />
              </div>

              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Project (Optional)
                </label>
                <input
                  type="text"
                  value={test.project}
                  onChange={(e) => updateTestimonial(test.id, 'project', e.target.value)}
                  className="input-field"
                />
              </div>

              <div className="md:col-span-2">
                <label className="block text-sm font-medium text-gray-700 mb-2">Message</label>
                <textarea
                  value={test.message}
                  onChange={(e) => updateTestimonial(test.id, 'message', e.target.value)}
                  className="input-field"
                  rows="4"
                />
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default TestimonialsEditor;
