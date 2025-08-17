import { Head, useForm, Link, router } from '@inertiajs/react';

export default function Step1() {
  const { data, setData, post, processing, errors } = useForm({ name: '', email: '' });

  const submit = (e) => {
    e.preventDefault();
    post(route('onboarding.storeStep1'));
  };

  return (
    <>
      <Head title="Onboarding - Step 1" />
      <div className="container py-5">
        <div className="row justify-content-center">
          <div className="col-md-6 col-lg-5">
            <div className="card shadow-sm border-0 rounded-4">
              <div className="card-body p-4">
                <h2 className="mb-4 text-center">Step 1: Account Information</h2>
                <form onSubmit={submit}>
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Full Name</label>
                    <input
                      className="form-control"
                      value={data.name}
                      onChange={(e) => setData('name', e.target.value)}
                      placeholder="Enter your full name"
                    />
                    {errors.name && <div className="text-danger small mt-1">{errors.name}</div>}
                  </div>
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Email</label>
                    <input
                      type="email"
                      className="form-control"
                      value={data.email}
                      onChange={(e) => setData('email', e.target.value)}
                      placeholder="Enter your email"
                    />
                    {errors.email && <div className="text-danger small mt-1">{errors.email}</div>}
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
