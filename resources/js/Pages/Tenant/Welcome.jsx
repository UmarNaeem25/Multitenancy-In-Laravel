import { Head } from '@inertiajs/react';

export default function Welcome() {
  const host = window.location.host;
  const isLandlord = host === 'landlord.myapp.test';
  const isTenant = host !== 'myapp.test' && host !== 'landlord.myapp.test';

  return (
    <>
      <Head title="Welcome" />
      <div className="bg-light text-dark min-vh-100 d-flex flex-column">
        <header className="container py-4 text-center">
          <h2>
            {isLandlord
              ? 'Welcome, Landlord!'
              : isTenant
              ? `Welcome, Tenant!`
              : 'Welcome to MyApp'}
          </h2>
        </header>

        <main className="container flex-grow-1 d-flex flex-column justify-content-center align-items-center text-center">
          <h1 className="mb-3">Welcome to MyApp</h1>
          <p className="lead mb-4">
            Your multi-tenant Laravel + React application starts here.
          </p>
        </main>

        <footer className="container py-3 text-center text-muted">
          &copy; {new Date().getFullYear()} MyApp
        </footer>
      </div>
    </>
  );
}
