import { useEffect } from 'react';
import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import JobPosting from '@/Types/JobPosting';

const Edit = ({ jobPosting }: { jobPosting: JobPosting }) => {
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

  const handleOnChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (event: React.SyntheticEvent) => {
    event.preventDefault();
    destroy(route('jobs.destroy', jobPosting));
  };

  return (
    <>
      <Head title="Delete the job" />
      <p>
        You are about to delete &quot;{jobPosting.title}&quot; by &quot;{jobPosting.company_name}&quot;
      </p>
      <p>Pease input your email and password to delete this job.</p>
      <form onSubmit={submit}>
        <div className="mt-4">
          <InputLabel htmlFor="email" value="Email" />
          <TextInput
            id="email"
            type="email"
            name="email"
            value={data.email}
            className="mt-1 block w-full"
            autoComplete="name"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.email} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="password" value="Password" />
          <TextInput
            id="password"
            type="password"
            name="password"
            value={data.password}
            className="mt-1 block w-full"
            autoComplete="new-password"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.password} className="mt-2" />
        </div>

        <PrimaryButton disabled={processing}>Delete</PrimaryButton>
      </form>
    </>
  );
};

export default Edit;
