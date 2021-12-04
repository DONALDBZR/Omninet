// Seller class
class Seller extends React.Component {
    // Render method
    render() {
        return [<Header />, <Main />, <Footer />];
    }
}
// Header class
class Header extends React.Component {
    // Render method
    render() {
        return (
            <header>
                <div id="logo">
                    <a href="../">Omninet</a>
                </div>
                <nav>
                    <div>
                        <a href="./" class="fas fa-user faUser"></a>
                    </div>
                    <div>
                        <a
                            href="../Logout"
                            class="fas fa-sign-out-alt faLogout"
                        ></a>
                    </div>
                </nav>
            </header>
        );
    }
}
// Main class
class Main extends React.Component {
    // Constructor method
    constructor(props) {
        super(props);
        this.state = {
            content: "",
            data: [],
        };
    }
    // Retrieve Data method
    retrieveData() {
        // Generating a GET request
        fetch("./SellerProfile.php", {
            method: "GET",
        })
            .then((response) => response.json())
            .then((data) =>
                this.setState({
                    content: data.content,
                    data: data.data,
                })
            );
    }
    // Component Did Mount method
    componentDidMount() {
        this.retrieveData();
    }
    // Render method
    render() {
        return (
            <main>
                <div id={this.state.content}>
                    <div id="dataItem">
                        <div id="dataItemData">
                            <div>
                                <h1>First Name:</h1>
                                <h1>{this.state.data.UserFirstName}</h1>
                            </div>
                            <div>
                                <h1>Last Name:</h1>
                                <h1>{this.state.data.UserLastName}</h1>
                            </div>
                            <div>
                                <h1>Mail Address:</h1>
                                <h1>{this.state.data.UserMailAddress}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        );
    }
}
// Footer class
class Footer extends React.Component {
    // Render method
    render() {
        return <footer>Omninet</footer>;
    }
}
// Rendering the page
ReactDOM.render(<Seller />, document.getElementById("app"));
