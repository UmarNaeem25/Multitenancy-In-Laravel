import { Head, Link } from '@inertiajs/react';

export default function Welcome({ auth }) {
  const host = window.location.host;
  const isLandlord = host === 'landlord.myapp.test';
  const isTenant = host !== 'myapp.test' && host !== 'landlord.myapp.test';
  const isMain = host === 'myapp.test';

  return (
    <>
      <Head title="Welcome" />
      <div className="bg-light text-dark min-vh-100 d-flex flex-column">
       
        <header className="container py-4 d-flex justify-content-end">
          <nav>
            {auth.user ? (
              <Link
                href={route('dashboard')}
                className="btn btn-outline-primary mx-1"
              >
                Dashboard
              </Link>
            ) : (
              <>
                {isLandlord && (
                  <>
                    <Link
                      href={route('landlord.login')}
                      className="btn btn-outline-secondary mx-1"
                    >
                      Log in
                    </Link>

                    <Link
                      href={route('landlord.register')}
                      className="btn btn-primary mx-1"
                    >
                      Register
                    </Link>
                  </>
                )}

                {isTenant && (
                  <>
                    <Link
                      href={route('tenant.login')}
                      className="btn btn-outline-secondary mx-1"
                    >
                      Tenant Log in
                    </Link>

                    <Link
                      href={route('tenant.register')}
                      className="btn btn-primary mx-1"
                    >
                      Tenant Register
                    </Link>
                  </>
                )}
              </>
            )}
          </nav>
        </header>

        <main className="container flex-grow-1 d-flex flex-column justify-content-center align-items-center text-center">
          <h1 className="mb-3">Welcome to MyApp</h1>
          <p className="lead mb-4">
            Your multi-tenant Laravel + React application starts here.
          </p>

          {isMain && (
            <Link
              href={route('onboarding.step1')}
              className="btn btn-primary btn-lg"
            >
              Start Onboarding
            </Link>
          )}
        </main>

       
        <footer className="container py-3 text-center text-muted">
          &copy; {new Date().getFullYear()} MyApp
        </footer>
      </div>
    </>
  );
}
