import { Head, useForm } from '@inertiajs/react';

export default function Step3() {
  const { data, setData, post, processing, errors } = useForm({
    company_name: '',
    subdomain: '',
    industry: '',
    company_size: '',
  });

  const submit = (e) => {
    e.preventDefault();
    post(route('onboarding.storeStep3'));
  };

  return (
    <>
      <Head title="Onboarding - Step 3" />
      <div className="container py-5">
        <div className="row justify-content-center">
          <div className="col-md-6 col-lg-5">
            <div className="card shadow-sm border-0 rounded-4">
              <div className="card-body p-4">
                <h2 className="mb-4 text-center">Step 3: Company Details</h2>
                <form onSubmit={submit}>
                  {/* Company Name */}
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Company Name</label>
                    <input
                      className="form-control"
                      value={data.company_name}
                      onChange={(e) => setData('company_name', e.target.value)}
                      placeholder="Enter your company name"
                    />
                    {errors.company_name && <div className="text-danger small mt-1">{errors.company_name}</div>}
                  </div>

                  {/* Subdomain */}
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Subdomain</label>
                    <div className="input-group">
                      <input
                        className="form-control"
                        value={data.subdomain}
                        onChange={(e) => setData('subdomain', e.target.value.toLowerCase())}
                        placeholder="yourcompany"
                      />
                      <span className="input-group-text">.myapp.test</span>
                    </div>
                    {errors.subdomain && <div className="text-danger small mt-1">{errors.subdomain}</div>}
                  </div>

                  {/* Industry */}
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Industry (optional)</label>
                    <input
                      className="form-control"
                      value={data.industry}
                      onChange={(e) => setData('industry', e.target.value)}
                      placeholder="e.g., Technology"
                    />
                  </div>

                  {/* Company Size */}
                  <div className="mb-4">
                    <label className="form-label fw-semibold">Company Size (optional)</label>
                    <input
                      className="form-control"
                      value={data.company_size}
                      onChange={(e) => setData('company_size', e.target.value)}
                      placeholder="e.g., 10-50 employees"
                    />
                  </div>

                  {/* Submit */}
                  <button className="btn btn-primary w-100 py-2" disabled={processing}>
                    {processing ? 'Processing...' : 'Continue'}
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
