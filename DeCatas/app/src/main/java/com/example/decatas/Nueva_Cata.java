package com.example.decatas;

import android.content.Context;
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

import java.io.BufferedOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.net.MalformedURLException;
import java.util.Arrays;
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

    public void createCata(View v) throws IOException {
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
        if(result.equals("IOException")){
            OutputStreamWriter outputStreamWriter = null;
            if(!Arrays.asList(fileList()).contains("requests.txt")) {
                new File(getFilesDir(), "requests.txt");
                outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_PRIVATE));
            }else {
                outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_APPEND));
            }
            outputStreamWriter.write("createCata.php;"+cataName+","+cataPass+"/");
            outputStreamWriter.close();

            android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Nueva_Cata.this);
            builder.setCancelable(true);
            builder.setTitle(R.string.error_connecting);
            builder.setMessage(R.string.ioexception_message);
            builder.show();
        }
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