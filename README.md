<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>

  <h1>MyApp – Multi-Tenant Laravel + React Application</h1>

  <p>
    This project is a multi-tenant SaaS-style application built with <strong>Laravel (PHP)</strong> and
    <strong>React (Inertia.js)</strong>. It provides database isolation for multiple tenants using the
    <strong>Spatie Multitenancy</strong> package.
  </p>

  <h2>Project Overview</h2>

  <p>The application runs across three domains:</p>

  <h3>Main Domain (<code>myapp.test</code>)</h3>
  <ul>
    <li>Entry point for onboarding new companies.</li>
    <li>Handles the multi-step onboarding process.</li>
  </ul>

  <h3>Landlord Domain (<code>landlord.myapp.test</code>)</h3>
  <ul>
    <li>Admin area for managing tenants.</li>
    <li>Displays the tenant list and details.</li>
  </ul>

  <h3>Tenant Subdomain (<code>{tenant}.myapp.test</code>)</h3>
  <ul>
    <li>Each company gets its own subdomain (e.g., <code>acme.myapp.test</code>).</li>
    <li>Users of that tenant can register and log in here.</li>
    <li>Each tenant has its own isolated database.</li>
  </ul>

  <h2>Features</h2>
  <ul>
    <li>Onboarding flow for new tenants (multi-step process).</li>
    <li>Automatic tenant provisioning (database creation + migrations).</li>
    <li>Database isolation per tenant.</li>
    <li>Separate landlord dashboard to manage tenants.</li>
    <li>Basic tenant-specific frontend with React + Inertia.js.</li>
  </ul>

  <h2>Requirements</h2>
  <ul>
    <li>PHP 8+</li>
    <li>Laravel 12</li>
    <li>npm</li>
    <li>MySQL</li>
  </ul>

</body>
</html>
