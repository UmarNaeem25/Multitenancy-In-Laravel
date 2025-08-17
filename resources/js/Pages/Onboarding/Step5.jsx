import { Head, useForm, usePage } from '@inertiajs/react';

export default function Step5() {
  const { props } = usePage();
  const snapshot = props.snapshot || {};
  const { post, processing } = useForm({});

  const confirm = (e) => {
    e.preventDefault();
    post(route('onboarding.storeStep5'));
  };


  const renderObject = (obj) => {
    return Object.entries(obj).map(([key, value]) => (
      <div className="mb-2" key={key}>
        <strong>{key}:</strong>{' '}
        {typeof value === 'object' && value !== null ? (
          <div className="ms-3">{renderObject(value)}</div>
        ) : (
          <span>{value}</span>
        )}
      </div>
    ));
  };

  return (
    <>
      <Head title="Onboarding - Confirm" />
      <div className="container py-5">
        <div className="row justify-content-center">
          <div className="col-md-8 col-lg-7">
            <div className="card shadow-sm border-0 rounded-4">
              <div className="card-body p-4">
                <h2 className="mb-4 text-center">Step 5: Confirm Your Details</h2>

                <div className="bg-light p-3 rounded border mb-4">
                  {renderObject(snapshot)}
                </div>

                <form onSubmit={confirm}>
                  <button className="btn btn-success w-100 py-2" disabled={processing}>
                    {processing ? 'Starting...' : 'Start Provisioning'}
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
