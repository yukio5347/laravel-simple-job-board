import { useEffect } from 'react';
import { Head, useForm } from '@inertiajs/react';
import Alert from '@/Components/Alert';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import JobPosting from '@/Types/JobPosting';

const Edit = ({ jobPosting, title }: { jobPosting: JobPosting; title: string }) => {
  const {
    data,
    setData,
    delete: destroy,
    processing,
    errors,
    reset,
  } = useForm({
    email: '',
    password: '',
  });

  useEffect(() => {
    return () => {
      reset('password');
    };
  }, []);

  const handleOnChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setData(e.target.name, e.target.value);
  };

  const submit = (e: React.SyntheticEvent) => {
    e.preventDefault();
    destroy(route('jobs.destroy', jobPosting));
  };

  return (
    <>
      <Head>
        <title>{title}</title>
        <meta name="robots" content="noindex, nofollow" />
      </Head>
      <Alert>
        <p>
          {__('You are about to delete ":title" by :company', {
            title: jobPosting.title,
            company: jobPosting.company_name,
          })}
        </p>
      </Alert>
      <form onSubmit={submit}>
        <div className="mt-4">
          <InputLabel htmlFor="email" value={__('Email Address')} isRequired={true} />
          <TextInput
            id="email"
            type="email"
            name="email"
            value={data.email}
            className="mt-1 block w-full"
            autoComplete="email"
            onChange={handleOnChange}
            maxLength="255"
            required
          />
          <InputError message={errors.email} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="password" value={__('Password')} isRequired={true} />
          <TextInput
            id="password"
            type="password"
            name="password"
            value={data.password}
            className="mt-1 block w-full"
            autoComplete="current-password"
            onChange={handleOnChange}
            maxLength="255"
            required
          />
          <InputError message={errors.password} className="mt-2" />
        </div>

        <PrimaryButton disabled={processing} className="mt-6">
          {__('Delete')}
        </PrimaryButton>
      </form>
    </>
  );
};

export default Edit;
