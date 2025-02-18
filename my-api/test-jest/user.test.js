const request = require("supertest");
const baseURL = "http://localhost:8000"; // url local api

describe("User API Tests", () => {
    let userId;

    //Post
    test("Create User - Valid Data", async () => {
        const res = await request(baseURL)
            .post("/users")
            .send({ name: "Edward Tua", email: "edward@gmail.com", age: 21 });

        expect(res.statusCode).toEqual(201);
        expect(res.body).toHaveProperty("id");

        userId = res.body.id;
        console.log("Created User ID:", userId);

        expect(userId).toBeDefined();
    });

    test("Create User - Missing Required Fields", async () => {
        const res = await request(baseURL).post("/users").send({});

        expect(res.statusCode).toEqual(422);
        expect(res.body).toHaveProperty("message");
        expect(res.body.errors).toHaveProperty("name");
        expect(res.body.errors).toHaveProperty("email");
        expect(res.body.errors).toHaveProperty("age");
    });

    test("Create User - Duplicate Email", async () => {
        const res = await request(baseURL)
            .post("/users")
            .send({ name: "Jhon", email: "edward@gmail.com", age: 22 });

        expect(res.statusCode).toEqual(422);
        expect(res.body.errors).toHaveProperty("email");
    });

    //Get
    test("Get All Users", async () => {
        const res = await request(baseURL).get("/users");

        expect(res.statusCode).toEqual(200);
        expect(Array.isArray(res.body)).toBe(true);
    });

    test("Get User by ID - Success", async () => {
        console.log("Fetching user with ID:", userId);
        const res = await request(baseURL).get(`/users/${userId}`);

        expect(res.statusCode).toEqual(200);
        expect(res.body).toHaveProperty("id", userId);
    });

    test("Get User by ID - Not Found", async () => {
        const res = await request(baseURL).get("/users/99999");

        expect(res.statusCode).toEqual(404);
        expect(res.body).toHaveProperty("message", "User not found");
    });


    //Update
    test("Update User - Valid Data", async () => {
        console.log("Updating user with ID:", userId);
        const res = await request(baseURL)
            .put(`/users/${userId}`)
            .send({ name: "Edward Updated", email: "edward_updated@gmail.com", age: 25 });

        expect(res.statusCode).toEqual(200);
        expect(res.body.name).toEqual("Edward Updated");
        expect(res.body.email).toEqual("edward_updated@gmail.com");
        expect(res.body.age).toEqual(25);
    });

    test("Update User - Duplicate Email", async () => {
        //add user baru untuk cek email uniq
        const newUser = await request(baseURL)
            .post("/users")
            .send({ name: "Another User", email: "another@example.com", age: 27 });

        expect(newUser.statusCode).toEqual(201);

        const res = await request(baseURL)
            .put(`/users/${userId}`)
            .send({ name: "Edward Updated", email: "another@example.com", age: 25 });

        expect(res.statusCode).toEqual(422);
        expect(res.body.errors).toHaveProperty("email");
    });

    //Delete
    test("Delete User - Success", async () => {
        console.log("Deleting user with ID:", userId);
        const res = await request(baseURL).delete(`/users/${userId}`);

        expect(res.statusCode).toEqual(200);
        expect(res.body).toHaveProperty("message", "User deleted!");
    });

    test("Delete User - Not Found", async () => {
        const res = await request(baseURL).delete("/users/99999");

        expect(res.statusCode).toEqual(404);
        expect(res.body).toHaveProperty("message", "User not found");
    });
});
