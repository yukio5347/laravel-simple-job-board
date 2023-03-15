const Alert = ({ children }: { children: React.ReactNode }) => {
  return (
    <div className="px-4 py-3 mb-4 rounded-r-md bg-sky-100 border-l-4 border-sky-500 text-sky-700" role="alert">
      {children}
    </div>
  );
};

export default Alert;
