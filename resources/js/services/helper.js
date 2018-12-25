export default {
    check(){
        return axios.post('/api/auth/check').then(response =>  {
            return !!response.data.authenticated;
        }).catch(error =>{
            return response.data.authenticated;
        });
    },
}
