import DashboardNav from "../components/DashboardNav";
import Sidebar from "../components/Sidebar";
import SwitchContainer from "../components/SwitchContainer";

function Dashboard() {
    return (
        <div className="dashboard">
            <Sidebar />
            <div className="container">
                <DashboardNav />
                <SwitchContainer />
            </div>
        </div>
    )
}

export default Dashboard;