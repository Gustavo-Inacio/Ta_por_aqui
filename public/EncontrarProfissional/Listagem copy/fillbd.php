<?php
   session_start();
   require '../../../logic/DbConnection.php';
   $con = new DbConnection();
    $con = $con->connect();

    //  for($i =0; $i < 400; $i++){
    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_RETURNTRANSFER => 1,
    //         CURLOPT_URL => 'https://randomuser.me/api/',
    //     ));

    //     $rep = curl_exec($curl);
    //     curl_close($curl);

    //     $rep = json_decode($rep);

        
    //     $data = $rep->results[0];
    //     echo '<pre>';
    //     print_r($data->email);
    //     echo '</pre>';
    //     $query = "";
    //     $query = "INSERT INTO usuarios(nome_usuario, sobrenome_usuario, fone_usuario, email_usuario, senha_usuario, data_nasc_usuario, sexo_usuario, classif_usuario, cep_usuario, uf_usuario, cidade_usuario, bairro_usuario, rua_usuario, numero_usuario, posicao_usuario, imagem_usuario) VALUES (:nome, :sobrenome, :telefone, :email, :senha, :data_nascimento, :sexo, :classificacao, :cep, :estado, :cidade, :bairro, :rua, :numero, ST_GeomFromText('POINT(".$data->location->coordinates->latitude . " " . $data->location->coordinates->longitude.")'), :img)";

    //     $stmt = $con->prepare($query);
    //     $stmt->bindValue(':nome', $data->name->first);
    //     $stmt->bindValue(':sobrenome', $data->name->last);
    //     $stmt->bindValue(':telefone', $data->phone);
    //     $stmt->bindValue(':email', $data->email);
    //     $stmt->bindValue(':senha', $data->login->password);
    //     $stmt->bindValue(':data_nascimento', $data->registered->age);
    //     $stmt->bindValue(':sexo', $data->gender);
    //     $stmt->bindValue(':classificacao', 2);
    //     $stmt->bindValue(':cep', $data->location->postcode);
    //     $stmt->bindValue(':estado', $data->location->state);
    //     $stmt->bindValue(':cidade', $data->location->city);
    //     $stmt->bindValue(':bairro', $data->location->city);
    //     $stmt->bindValue(':rua', $data->location->street->name);
    //     $stmt->bindValue(':numero', $data->location->street->number);
    //     $stmt->bindValue(':img', $data->picture->thumbnail);
        
    //     $stmt->execute();

    //  }


    // $lorem = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

    // Why do we use it?
    // It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
    
    
    // Where does it come from?
    // Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of de Finibus Bonorum et Malorum(The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, Lorem ipsum dolor sit amet., comes from a line in section 1.10.32.";

#montando orcamento
/*
    for($i =1; $i < 100; $i++){

    $query = "INSERT INTO servicos(id_prestador_servico, nome_servico, tipo_servico, desc_servico, crit_orcamento_servico) values(:prestador, :nome_servico, :tipo, :descricao, 'A definir orcamento')";
    #inserindo informações

    $stmt = $con->prepare($query);
     $stmt->bindValue(":prestador", mt_rand(1, 50));
    // $stmt->bindValue(":prestador", 1);
    $stmt->bindValue(":nome_servico", 'servico ' . $i);
    $stmt->bindValue(":tipo", 1);
    $stmt->bindValue(":descricao", $lorem);
   
    $stmt->execute();

    //Adicionando as categorias do serviço
    $ultimo_id_servico = $con->lastInsertId();

    $query2 = "SELECT id_categoria FROM subcategorias WHERE id_subcategoria = " . mt_rand(1,3);
    $stmt = $con->query($query2);
    $id_categoria_subcategoria = $stmt->fetch(PDO::FETCH_OBJ);

    $subcategorias = array(
        1, 2, 3
    );

    foreach ($subcategorias as $subcategoria){
        $query3 = "INSERT INTO servico_categorias(id_servico, id_categoria, id_subcategoria) values (:id_servico, :id_categoria, :id_subcategoria)";
        $stmt = $con->prepare($query3);
        $stmt->bindValue(":id_servico", $ultimo_id_servico);
        $stmt->bindValue(":id_categoria", $id_categoria_subcategoria->id_categoria);
        $stmt->bindValue(":id_subcategoria", $subcategoria);
        $stmt->execute();
    }

    //Salvando a imagem e adicionando ao banco de dados
    $query3 = "INSERT INTO servico_imagens(id_servico, dir_servico_imagem) VALUES (:ultimo_id_servico, :nome_imagem)";
        $stmt = $con->prepare($query3);
        $stmt->bindValue(":ultimo_id_servico", $ultimo_id_servico);
        $stmt->bindValue(":nome_imagem", 'https://picsum.photos/200');
        $stmt->execute();


 }*/
?>