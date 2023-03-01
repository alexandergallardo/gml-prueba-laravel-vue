<template>
    <div class="card">
        <div class="card-header">
            Lista de usuarios
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" @click="abrirModalCrear">
                <i class="fa fa-user-plus"></i>Nuevo usuario
            </button>

            <!-- Modal formulario -->
            <div class="modal fade" id="modalForm">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title"><i class="fa fa-user-plus"></i> {{titulo}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nombre">Nombres</label>
                                    <input type="text" class="form-control" id="nombre" required="" v-model="datoUsuario.name">
                                </div>
                                <div class="form-group">
                                    <label for="apellido">Apellidos</label>
                                    <input type="text" class="form-control" id="apellido"  v-model="datoUsuario.lastname">
                                </div>
                                <div class="form-group">
                                    <label for="cedula">Cédula</label>
                                    <input type="text" class="form-control" id="cedula"  v-model="datoUsuario.dni">
                                </div>
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" class="form-control" id="direccion"  v-model="datoUsuario.direction">
                                </div>
                                <div class="form-group">
                                    <label for="celular">Celular</label>
                                    <input type="number" maxlength="10" class="form-control" id="celular"  v-model="datoUsuario.cellphone" @keypress="isNumber($event)">
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input v-validate="'required|email'" type="email" class="form-control" id="email"  v-model="datoUsuario.email">
                                </div>
                                <div class="form-group">
                                    <label for="pais">País</label>
                                    <select class="form-control" v-model="datoUsuario.country" id="pais">
                                        <option
                                            v-for="(pais, index) in this.listaPaises" :key="index"
                                            :value="pais.name.official"
                                            :selected="pais.name.official == datoUsuario.country">{{ pais.name.official }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="categoria">Categoría</label>
                                    <select class="form-control" v-model="datoUsuario.category_id" id="categoria">
                                        <option
                                            v-for="(cat,index) in this.listaCategorias" :key="index"
                                            :value="index"
                                            :selected="index == datoUsuario.category_id">{{ cat }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" @click.prevent="crear" v-if="btnCrear">Crear usuario</button>
                                <button type="submit" class="btn btn-primary" @click.prevent="editar" v-if="btnEditar">Editar usuario</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped" id="sampleTable">
                    <thead>
                        <tr>
                          <th>Id</th>
                          <th>Dni</th>
                          <th>Nombres</th>
                          <th>Apellidos</th>
                          <th>Pais</th>
                          <th>Email</th>
                          <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in usuarios">
                            <td>{{user.id}}</td>
                            <td>{{user.dni}}</td>
                            <td>{{user.name}}</td>
                            <td>{{user.lastname}}</td>
                            <td>{{user.country}}</td>
                            <td>{{user.email}}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" type="button" @click="abrirModalEditar(user)"><i class="fas fa-edit"></i> </button>
                                <button class="btn btn-danger btn-sm" type="button" @click="eliminar(user)"><i class="fas fa-trash"></i> </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

  export default {
    mounted() {
        this.getUser()
        this.getCountry()
        this.getCategories()
    },
    data(){
      return {
        usuarios: [],
        listaPaises: [],
        listaCategorias: [],
        info: [],
        datoUsuario: {name:'', email:'', country:'', lastname:'', dni:'', direction:'', cellphone:0, category_id:0},
        titulo:'',
        btnCrear:false,
        btnEditar:false,
        idUser:''
      }
    },
    methods:{
      getCountry(){
        let nameRegion =  'South America';
        axios.get('https://restcountries.com/v3.1/subregion/'+nameRegion).then(res=>{
          this.listaPaises = res.data
          //let regiones = res.data
          //console.log(res.data);
          //  for (region of regiones) {
          //      console.log(region.name.official)
         //   }

        });
      },
      getCategories(){
            axios.get('categories').then(res=>{
                this.listaCategorias = res.data
                console.log(res.data);
            });
        },
      getUser(){
            axios.get('user').then(res=>{
                $('#sampleTable').DataTable().destroy()
                this.usuarios = res.data
                console.log(res.data);
                this.$tablaGlobal('#sampleTable')
            });
        },
        isNumber: function (evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode < 48 || charCode > 57 )) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
      crear(){
        axios.post('/user',this.datoUsuario).then(res=>{
          this.getUser()
          $('#modalForm').modal('hide')
          swal("Felicidades!", "Usuario creado correctamente!", "success");
        }).catch(function (error) {
          var array = Object.values(error.response.data.errors)
          array.forEach(element => swal(String(element)))
        });
      },
      abrirModalCrear(){
        this.datoUsuario= {name:'', email:'', country:'', lastname:'', dni:'', direction:'', cellphone:0, category_id:0}
        this.titulo=' Crear usuario'
        this.btnCrear=true
        this.btnEditar=false
        $('#modalForm').modal('show')
      },
      abrirModalEditar(datos){
        this.datoUsuario= {name:datos.name, email:datos.email, country:datos.country, lastname:datos.lastname, dni:datos.dni, direction:datos.direction, cellphone:datos.cellphone, category_id:datos.category_id}
        this.titulo=' Editar usuario'
        this.btnCrear=false
        this.btnEditar=true
        this.idUser=datos.id
        $('#modalForm').modal('show')
      },
      editar(){
        axios.put('user/'+this.idUser,this.datoUsuario).then(res=>{
          this.idUser=''
          this.getUser()
          $('#modalForm').modal('hide')
          swal("Felicidades!", "Usuario editado correctamente!", "success");
        }).catch(function (error) {
          var array = Object.values(error.response.data.errors)
          array.forEach(element => swal(String(element)))
        });
      },
      eliminar(datos){
        swal({
          title: "¿Está seguro de eliminar "+datos.name+"?",
          text: "Se eliminara permanentemente!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete('user/'+datos.id).then(res=>{
              this.getUser()
              swal("Usuario eliminado correctamente!", {
              icon: "success",
            });
            }).catch(function (error) {
              var array = Object.values(error.response.data.errors)
              array.forEach(element => swal(String(element)))
            });

          }
        });
      }
    }
  }


</script>
