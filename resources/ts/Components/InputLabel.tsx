const InputLabel = ({
  value = '',
  className = '',
  children,
  ...props
}: {
  value?: string;
  className?: string;
  children?: React.ReactNode;
}) => {
  return (
    <label {...props} className={`block font-medium text-sm ${className}`}>
      {value ? value : children}
    </label>
  );
};

export default InputLabel;
