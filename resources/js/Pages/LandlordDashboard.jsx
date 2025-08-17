import { Head, Link } from '@inertiajs/react';

export default function LandlordDashboard({ tenants }) {
  return (
    <>
      <Head title="Landlord Dashboard" />
      <div className="container py-5">
        <h1>Landlord Dashboard</h1>
        <ul>
          {tenants.map(t => (
            <li key={t.id}>{t.name} — {t.status}</li>
          ))}
        </ul>
      </div>
    </>
  );
}
