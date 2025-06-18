const fetchData = document.getElementById("fetchData");
const username = document.getElementById("username");
const list = document.getElementById("list");

const getData = async() =>{
    try{
        const res = await fetch(`http://localhost:8000/`,{
            method:"GET"
        });
        const data = await res.json();

        console.log(data);

        // let lt = ``
        // if(data.status === "success"){
        //     data.data.map((dt)=>{
        //         console.log(dt.username);
        //         lt += `<li>${dt.username}</li>`
        //     });

        //     list.innerHTML = lt;
        // }
    }
    catch(e){
        console.log(e);
    }
}

const createData = async() =>{
    // console.log(username.value)
    try{
        const res = await fetch(`http://localhost:8000/api/create`,{
            method:"POST",
            headers:{
                'content-type':"application/json"
            },
            body:JSON.stringify({
                name: username.value,
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
// getData()
fetchData.addEventListener("click", async ()=>{
    await getData()
})
