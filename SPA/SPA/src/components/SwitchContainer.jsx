import Switch from './Switch'; // Suponiendo que tienes un componente SwitchBox

function SwitchContainer() {
  return (
    <div className="switchContainer">
      {/* Agregar múltiples SwitchBox */}
      <Switch/>
      <Switch/>
      <Switch/>
      <Switch/>
      <Switch/>
      <Switch/>
      <Switch/>
    </div>
  );
}

export default SwitchContainer;
