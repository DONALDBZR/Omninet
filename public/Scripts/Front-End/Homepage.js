// Homepage class
class Homepage extends React.Component {
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
                    <a href="./">Omninet</a>
                </div>
                <nav>
                    <div>
                        <a
                            href="./Shop"
                            class="fas fa-shopping-cart faCart"
                        ></a>
                    </div>
                    <div>
                        <a href="./User" class="fas fa-user faUser"></a>
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
        fetch("./HomepageGET.php", {
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
                    <div>
                        <img
                            src={this.state.data.ItemImage}
                            alt={this.state.data.ImageId}
                        />
                    </div>
                    <div>
                        <div>
                            <h1>{this.state.data.ItemName}</h1>
                        </div>
                        <div>
                            <a href="./Buyer">Shop Now</a>
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
ReactDOM.render(<Homepage />, document.getElementById("app"));
