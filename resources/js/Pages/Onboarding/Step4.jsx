import { Head, useForm } from '@inertiajs/react';

export default function Step4() {
  const { data, setData, post, processing, errors } = useForm({
    billing_name: '',
    address: '',
    country: '',
    phone: '',
  });

  const submit = (e) => {
    e.preventDefault();
    post(route('onboarding.storeStep4'));
  };

  return (
    <>
      <Head title="Onboarding - Step 4" />
      <div className="container py-5">
        <div className="row justify-content-center">
          <div className="col-md-6 col-lg-5">
            <div className="card shadow-sm border-0 rounded-4">
              <div className="card-body p-4">
                <h2 className="mb-4 text-center">Step 4: Billing Information</h2>
                <form onSubmit={submit}>
                  {/* Billing Name */}
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Billing Name</label>
                    <input
                      className="form-control"
                      value={data.billing_name}
                      onChange={(e) => setData('billing_name', e.target.value)}
                      placeholder="Enter billing name"
                    />
                    {errors.billing_name && <div className="text-danger small mt-1">{errors.billing_name}</div>}
                  </div>

                  {/* Address */}
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Address</label>
                    <input
                      className="form-control"
                      value={data.address}
                      onChange={(e) => setData('address', e.target.value)}
                      placeholder="Street, City, ZIP"
                    />
                    {errors.address && <div className="text-danger small mt-1">{errors.address}</div>}
                  </div>

                  {/* Country */}
                  <div className="mb-3">
                    <label className="form-label fw-semibold">Country (ISO2)</label>
                    <input
                      className="form-control"
                      value={data.country}
                      onChange={(e) => setData('country', e.target.value.toUpperCase())}
                      placeholder="e.g., US"
                    />
                    {errors.country && <div className="text-danger small mt-1">{errors.country}</div>}
                  </div>

                  {/* Phone */}
                  <div className="mb-4">
                    <label className="form-label fw-semibold">Phone</label>
                    <input
                      className="form-control"
                      value={data.phone}
                      onChange={(e) => setData('phone', e.target.value)}
                      placeholder="Enter phone number"
                    />
                    {errors.phone && <div className="text-danger small mt-1">{errors.phone}</div>}
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
