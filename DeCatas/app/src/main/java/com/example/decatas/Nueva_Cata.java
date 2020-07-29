package com.example.decatas;

import android.content.Intent;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

public class Nueva_Cata extends AppCompatActivity {

    private String idUsuario;
    public EditText editName,editPass;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_nueva__cata);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        editName = (EditText)findViewById(R.id.editTextCataName);
        editPass = (EditText)findViewById(R.id.editTextTextCataPassword);
    }

    public void createCata(View v) throws MalformedURLException {
        editName.setBackgroundResource(R.drawable.input_normal);
        editPass.setBackgroundResource(R.drawable.input_normal);

        String cataName = editName.getText().toString();
        String cataPass = editPass.getText().toString();

        if(cataName.equals("")){
            Toast.makeText(this, "Escribe un nombre para la cata", Toast.LENGTH_LONG).show();
            editName.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(cataPass.equals("")){
            Toast.makeText(this, "Escribe una contraseña para la cata", Toast.LENGTH_LONG).show();
            editPass.setBackgroundResource(R.drawable.input_error);
            return;
        }

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        params.put("n",cataName);
        params.put("p",cataPass);
        Connection con = new Connection(getApplication(),"createCata.php",params);
        while(con.getRes()==null);
        String result = con.getRes();
        if(!result.equals("0")){
            String idCata = result;
            Intent intent = new Intent(getApplicationContext(),Cata.class);
            intent.putExtra("idUsuario",idUsuario);
            intent.putExtra("idCata",idCata);
            startActivity(intent);
        } else {
            Toast.makeText(this, "No se pudo crear la cata", Toast.LENGTH_LONG).show();
        }
    }
}