import Layout from '@/Layouts/Layout';

export default function TenantIndex({ tenants }) {
  console.log(tenants)
  return (
    <Layout title="Tenants">
    <div className="container py-5">
    <h1 className="mb-4 text-center">Tenant Dashboard</h1>
    
    {tenants.length === 0 ? (
      <div className="p-4 bg-blue-50 text-blue-800 rounded-md border border-blue-100">
      No tenants found.
      </div>
      
    ) : (
      <div className="table-responsive">
      <table className="table table-striped table-hover align-middle">
      <thead className="table-dark">
      <tr>
      <th>#</th>
      <th>Tenant Name</th>
      <th>Subdomain</th>
      <th>Status</th>
      </tr>
      </thead>
      <tbody>
      {tenants.map((tenant, index) => (
        <tr key={tenant.id}>
        <td>{index + 1}</td>
        <td>{tenant.name}</td>
        <td>{tenant.domain}</td>
        <td>
        {tenant.status === 'provisioned' ? (
          <span className="badge bg-success">Active</span>
        ) : (
          <span className="badge bg-warning">Pending</span>
        )}
        </td>
        </tr>
      ))}
      </tbody>
      </table>
      </div>
    )}
    </div>
    </Layout>
  );
}
