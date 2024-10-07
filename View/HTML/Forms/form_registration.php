<div class="container mt-5">
    <h2 class="h3">Registration</h2>
    <form method="POST" action="">
        <div class="form-check mt-3">
            <input type="radio" class="form-check-input" name="role" id="radio1" value="2">
            <label class="form-check-label" for="radio1">User</label>
        </div>
        <div class="form-check">
            <input type="radio" class="form-check-input" name="role" id="radio2" value="3">
            <label class="form-check-label" for="radio2">Company</label>
        </div>
        <label for="mail" class="form-label m-2 fw-bold">Mail adress:</label>
        <input class="form-control bg-dark text-white" type="text" name="mail" id="mail" placeholder="Email adress"
            require>

        <label for="password" class="form-label m-2">Password</label>
        <input class="form-control bg-dark text-white" type="text" name="pass" id="password" placeholder="Password" require>

        <label for="pass_again" class="form-label m-2">Password Again</label>
        <input class="form-control bg-dark text-white" type="text" name="pass_again" id="pass_again" placeholder="Password again"
            require>

        <input class="btn btn-primary mt-3" type="submit" value="Registration">
    </form>
</div>
