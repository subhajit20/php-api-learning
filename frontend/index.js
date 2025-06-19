const fetchData = document.getElementById("fetchData");
const username = document.getElementById("username");
const list = document.getElementById("list");

const getData = async() =>{
    try{
        const res = await fetch(`http://localhost:8000/api/users`,{
            method:"GET"
        });
        const data = await res.json();

        console.log(data);

        let lt = ``
        if(data.users.length > 0){
            data.users.map((dt)=>{
                console.log(dt.username);
                lt += `<li style="padding:5px">${dt.username}</li>`
            });

            list.innerHTML = lt;
        }
    }
    catch(e){
        console.log(e);
    }
}

const createData = async() =>{
    // console.log(username.value)
    try{
        const res = await fetch(`http://localhost:8000/api/register`,{
            method:"POST",
            body:JSON.stringify({
                username: username.value,
                roll: 1
            })
        });
        const data = await res.json();

        console.log(data);
    }
    catch(e){
        console.log(e);
    }
}

const getUserById = async() =>{
    // console.log(username.value)
    try{
        const res = await fetch(`http://localhost:8000/api/user?id=7`,{
            method:"GET"
        });
        const data = await res.json();

        console.log(data);
    }
    catch(e){
        console.log(e);
    }
}
// getData()
fetchData.addEventListener("click", async ()=>{
    await getUserById();
})
