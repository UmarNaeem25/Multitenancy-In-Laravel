
import { Head } from '@inertiajs/react';

export default function Layout({ children, title }) {
  return (
    <div>
      <Head title={title} />
      <main>{children}</main>
    </div>
  );
}
