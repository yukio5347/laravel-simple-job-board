const Select = ({
  options,
  value,
  className = '',
  ...props
}: {
  options: Record<string, string | number>;
  value: string;
  className: string;
}) => {
  return (
    <div className="flex flex-col items-start">
      <select
        {...props}
        value={value}
        className={
          'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm ' +
          className
        }
      >
        {Object.keys(options).map((option: string, index: number) => (
          <option key={index} value={option}>
            {options[option]}
          </option>
        ))}
      </select>
    </div>
  );
};

export default Select;
