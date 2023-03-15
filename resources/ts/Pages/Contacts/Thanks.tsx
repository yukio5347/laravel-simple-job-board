import { Head } from '@inertiajs/react';
import Alert from '@/Components/Alert';

const Thanks = ({ title, description }: { title: string; description: string }) => {
  return (
    <>
      <Head>
        <title>{title}</title>
        <meta name="description" content={description} />
      </Head>
      <Alert>
        <p>{__('Your inquiry has been sent.')}</p>
      </Alert>
      <a href={route('home')} className="text-sky-600">
        « {__('Back to home')}
      </a>
    </>
  );
};

export default Thanks;
