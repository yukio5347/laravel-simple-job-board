import { Head, useForm } from '@inertiajs/react';
import Alert from '@/Components/Alert';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import Textarea from '@/Components/Textarea';
import TextInput from '@/Components/TextInput';
import Select from '@/Components/Select';
import JobPosting from '@/Types/JobPosting';

const Edit = ({
  jobPosting,
  title,
  genders,
}: {
  jobPosting: JobPosting;
  title: string;
  genders: Record<string, string>;
}) => {
  const { data, setData, post, processing, errors } = useForm({
    name: '',
    email: '',
    telephone: '',
    address: '',
    birthday: '',
    gender: '',
    summary: '',
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
      <Head>
        <title>{title}</title>
        <meta name="robots" content="noindex, nofollow" />
      </Head>
      <Alert>
        <p>
          {__('You are applying for ":title" by :company', {
            title: jobPosting.title,
            company: jobPosting.company_name,
          })}
        </p>
      </Alert>
      <form onSubmit={submit}>
        <div className="mt-4">
          <InputLabel htmlFor="name" value={__('Your Name')} isRequired={true} />
          <TextInput
            id="name"
            name="name"
            value={data.name}
            className="mt-1 block w-full"
            autoComplete="name"
            onChange={handleOnChange}
            maxLength="255"
            required
          />
          <InputError message={errors.name} className="mt-2" />
        </div>

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
          <InputLabel htmlFor="telephone" value={__('Telephone')} />
          <TextInput
            id="telephone"
            name="telephone"
            value={data.telephone}
            className="mt-1 block w-full"
            autoComplete="telephone"
            onChange={handleOnChange}
            maxLength="255"
          />
          <InputError message={errors.telephone} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="address" value={__('Address')} />
          <TextInput
            id="address"
            name="address"
            value={data.address}
            className="mt-1 block w-full"
            autoComplete="address"
            onChange={handleOnChange}
            maxLength="255"
          />
          <InputError message={errors.address} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="birthday" value={__('Birthday')} />
          <TextInput
            id="birthday"
            name="birthday"
            value={data.birthday}
            className="mt-1 block w-full"
            type="date"
            onChange={handleOnChange}
            max={dateToString(new Date())}
          />
          <InputError message={errors.birthday} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="gender" value={__('Gender')} />
          <Select
            id="gender"
            name="gender"
            options={genders}
            value={data.gender}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            maxLength="255"
          />
          <InputError message={errors.gender} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="summary" value={__('Summary')} isRequired={true} />
          <Textarea
            id="summary"
            name="summary"
            value={data.summary}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            maxLength="20000"
            required
          />
          <InputError message={errors.summary} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="education" value={__('Education')} />
          <Textarea
            id="education"
            name="education"
            value={data.education}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            maxLength="20000"
          />
          <InputError message={errors.education} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="work_history" value={__('Work History')} />
          <Textarea
            id="work_history"
            name="work_history"
            value={data.work_history}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            maxLength="20000"
          />
          <InputError message={errors.work_history} className="mt-2" />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="certificates" value={__('Skills and Certificates')} />
          <Textarea
            id="certificates"
            name="certificates"
            value={data.certificates}
            className="mt-1 block w-full"
            onChange={handleOnChange}
            maxLength="20000"
          />
          <InputError message={errors.certificates} className="mt-2" />
        </div>
        <PrimaryButton disabled={processing} className="mt-6">
          {__('Apply')}
        </PrimaryButton>
      </form>
    </>
  );
};

export default Edit;
