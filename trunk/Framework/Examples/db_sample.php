<h1>Users </h1>
    <table id="tb">
        <thead><tr><th>Id</th><th>Name</th></tr></thead>
        <tbody>
            <?php foreach ($data as $user): ?>
            <tr>
                <td><?php y($user->Id)?></td>
                <td><?php y($user->Name)?></td>
            </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
<?php

    $data=Database::Instance()->Query()->On('users')->Where("name LIKE 'Evance'")->Select('name')->Resultset()->AsAssoc("User");

    // var_dump($q);
    //$q->On('users')->Where("name='Yalamo'")->Update("name='Vibran'");
    //$q->On('users')->Insert(array("Id","name"),array(null,"Thomas"));
    $this->Set("data",$data);



   // $db->q("SELECT* FROM users ; ")->ResultSet()->AsAssoc();

   //$keys=array("name","age","phone");
   //$values=array(array("evance",25,"+044 0778 5347"),array("Benjamin",28,"+224 66 55 07 78"));
   //Insert($keys,$values,true)

   //$this->Set("data",  $db->Handle()->On("users")->Where("name='evane'")->Where("age=3","OR")->Update(array("name='evance'","age=age+4")));

    