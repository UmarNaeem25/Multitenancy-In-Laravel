import { Head, useForm } from '@inertiajs/react';

export default function Step2() {
  const { data, setData, post, processing, errors } = useForm({ password: '', password_confirmation: '' });

  const submit = (e) => {
    e.preventDefault();
    post(route('onboarding.storeStep2'));
  };

  return (
    <>
      <Head title="Onboarding - Step 2" />
      <div className="container py-5">
        <div className="row justify-content-center">
          <div className="col-md-6 col-lg-5">
            <div className="card shadow-sm border-0 rounded-4">
              <div className="card-body p-4">
                <h2 className="mb-4 text-center">Step 2: Create a Password</h2>
                <form onSubmit={submit}>
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Password</label>
                    <input
                      type="password"
                      className="form-control"
                      value={data.password}
                      onChange={(e) => setData('password', e.target.value)}
                      placeholder="Enter your password"
                    />
                    {errors.password && <div className="text-danger small mt-1">{errors.password}</div>}
                  </div>
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Confirm Password</label>
                    <input
                      type="password"
                      className="form-control"
                      value={data.password_confirmation}
                      onChange={(e) => setData('password_confirmation', e.target.value)}
                      placeholder="Re-enter your password"
                    />
                  </div>
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
