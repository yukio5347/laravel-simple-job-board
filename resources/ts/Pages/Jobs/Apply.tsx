import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import Textarea from '@/Components/Textarea';
import TextInput from '@/Components/TextInput';
import Select from '@/Components/Select';
import JobPosting from '@/Types/JobPosting';

const Edit = ({ genders, jobPosting }: { genders: Record<string, string>; jobPosting: JobPosting }) => {
  const { data, setData, post, processing, errors, reset } = useForm({
    name: '',
    email: '',
    telephone: '',
    address: '',
    birthday: '',
    gender: '',
    description: '',
    education: '',
    work_history: '',
    certificates: '',
  });

  const handleOnChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (event: React.SyntheticEvent) => {
    event.preventDefault();
    post(route('jobs.apply', jobPosting));
  };

  return (
    <>
      <Head title="Apply for the job" />
      <p>
        You are about to apply for &quot;{jobPosting.title}&quot; by &quot;{jobPosting.company_name}&quot;
      </p>

      <form onSubmit={submit}>
        <div className="mt-4">
          <InputLabel htmlFor="name" value="Name" />
          <TextInput
            id="name"
            name="name"
            value={data.name}
            className="mt-1 block w-full"
            autoComplete="name"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.name} className="mt-2" />
        </div>

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
          <InputLabel htmlFor="address" value="telephone" />
          <TextInput
            id="telephone"
            name="telephone"
            value={data.telephone}
            className="mt-1 block w-full"
            autoComplete="telephone"
            onChange={handleOnChange}
          />
          <InputError message={errors.telephone} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="address" value="address" />
          <TextInput
            id="address"
            name="address"
            value={data.address}
            className="mt-1 block w-full"
            autoComplete="address"
            onChange={handleOnChange}
          />
          <InputError message={errors.address} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="closed_at" value="birthday" />
          <TextInput
            id="birthday"
            name="birthday"
            value={data.birthday}
            className="mt-1 block w-full"
            type="date"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.birthday} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="gender" value="gender" />
          <Select
            id="gender"
            name="gender"
            options={genders}
            value={data.gender}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.gender} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="description" value="description" />
          <Textarea
            id="description"
            name="description"
            value={data.description}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.description} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="education" value="education" />
          <Textarea
            id="education"
            name="education"
            value={data.education}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.education} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="work_history" value="work_history" />
          <Textarea
            id="work_history"
            name="work_history"
            value={data.work_history}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.work_history} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="certificates" value="certificates" />
          <Textarea
            id="certificates"
            name="certificates"
            value={data.certificates}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            required
          />
          <InputError message={errors.certificates} className="mt-2" />
        </div>
        <PrimaryButton disabled={processing}>Post</PrimaryButton>
      </form>
    </>
  );
};

export default Edit;
