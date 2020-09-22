package com.example.decatas;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.annotation.Nullable;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.content.FileProvider;

import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.net.MalformedURLException;
import java.text.SimpleDateFormat;
import java.util.Arrays;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Objects;

public class Nueva_Cerveza extends AppCompatActivity {

    String idUsuario;
    EditText inputName,inputAroma,inputApariencia,inputSabor,inputCuerpo,inputBotellin;
    String name,aroma,apariencia,sabor,botellin,cuerpo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_nueva__cerveza);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        inputName = (EditText)findViewById(R.id.inputName);
        inputAroma = (EditText)findViewById(R.id.inputName2);
        inputApariencia = (EditText)findViewById(R.id.inputName3);
        inputSabor = (EditText)findViewById(R.id.inputName4);
        inputCuerpo = (EditText)findViewById(R.id.inputName5);
        inputBotellin = (EditText)findViewById(R.id.inputName6);

    }

    public void goToUser(View v){
        Intent intent = new Intent(getApplicationContext(),User.class);
        startActivity(intent);
    }

    public void saveBeer(View v) throws IOException {
        inputName.setBackgroundResource(R.drawable.input_normal);
        inputAroma.setBackgroundResource(R.drawable.input_normal);
        inputSabor.setBackgroundResource(R.drawable.input_normal);
        inputCuerpo.setBackgroundResource(R.drawable.input_normal);
        inputApariencia.setBackgroundResource(R.drawable.input_normal);
        inputBotellin.setBackgroundResource(R.drawable.input_normal);

        name = inputName.getText().toString();
        aroma = inputAroma.getText().toString();
        apariencia = inputApariencia.getText().toString();
        sabor = inputSabor.getText().toString();
        cuerpo = inputCuerpo.getText().toString();
        botellin = inputBotellin.getText().toString();

        if(name.equals("")){
            Toast.makeText(getApplicationContext(), R.string.empty_beer_name,Toast.LENGTH_LONG).show();
            inputName.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(aroma.equals("")){
            Toast.makeText(getApplicationContext(), R.string.empty_smell_beer,Toast.LENGTH_LONG).show();
            inputAroma.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(aroma)<0 || Integer.parseInt(aroma)>10){
            Toast.makeText(getApplicationContext(),getResources().getString(R.string.error_number_in_between),Toast.LENGTH_LONG).show();
            inputAroma.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(apariencia.equals("")){
            Toast.makeText(getApplicationContext(), R.string.empty_appearance_beer,Toast.LENGTH_LONG).show();
            inputApariencia.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(apariencia)<0 || Integer.parseInt(apariencia)>10){
            Toast.makeText(getApplicationContext(),getResources().getString(R.string.error_number_in_between),Toast.LENGTH_LONG).show();
            inputApariencia.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(sabor.equals("")){
            Toast.makeText(getApplicationContext(), R.string.empty_taste_beer,Toast.LENGTH_LONG).show();
            inputSabor.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(sabor)<0 || Integer.parseInt(sabor)>10){
            Toast.makeText(getApplicationContext(),getResources().getString(R.string.error_number_in_between),Toast.LENGTH_LONG).show();
            inputSabor.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(cuerpo.equals("")){
            Toast.makeText(getApplicationContext(), R.string.empty_body_beer,Toast.LENGTH_LONG).show();
            inputCuerpo.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(cuerpo)<0 || Integer.parseInt(cuerpo)>10){
            Toast.makeText(getApplicationContext(),getResources().getString(R.string.error_number_in_between),Toast.LENGTH_LONG).show();
            inputCuerpo.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(botellin.equals("")){
            Toast.makeText(getApplicationContext(), R.string.empty_bottle_beer,Toast.LENGTH_LONG).show();
            inputBotellin.setBackgroundResource(R.drawable.input_error);
            return;
        }
        if(Integer.parseInt(botellin)<0 || Integer.parseInt(botellin)>10){
            Toast.makeText(getApplicationContext(),getResources().getString(R.string.error_number_in_between),Toast.LENGTH_LONG).show();
            inputBotellin.setBackgroundResource(R.drawable.input_error);
            return;
        }
        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        params.put("n",name);
        params.put("ar",aroma);
        params.put("ap",apariencia);
        params.put("s",sabor);
        params.put("c",cuerpo);
        params.put("b",botellin);
        Connection con = new Connection(getApplicationContext(),"nuevaCervezaIndividual.php",params);
        while(con.getRes()==null);
        String res = con.getRes();
        if(res.equals("IOException")){ // GUARDAR PETICION EN FICHERO
            OutputStreamWriter outputStreamWriter = null;
            if(!Arrays.asList(fileList()).contains("requests.txt")) {
                new File(getFilesDir(), "requests.txt");
                outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_PRIVATE));
            }else {
                outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_APPEND));
            }

            outputStreamWriter.write("nuevaCervezaIndividual.php;"+name+","+aroma+","+apariencia+","+sabor+","+cuerpo+","+botellin+"/");
            outputStreamWriter.close();

            android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Nueva_Cerveza.this);
            builder.setCancelable(true);
            builder.setTitle(R.string.error_connecting);
            builder.setMessage(R.string.ioexception_message);
            builder.show();


        } else if(res.equals("1")){
            Toast.makeText(getApplicationContext(), R.string.beer_saved_successfully,Toast.LENGTH_LONG).show();
            inputName.setText("", TextView.BufferType.EDITABLE);
            inputAroma.setText("", TextView.BufferType.EDITABLE);
            inputApariencia.setText("", TextView.BufferType.EDITABLE);
            inputSabor.setText("", TextView.BufferType.EDITABLE);
            inputCuerpo.setText("", TextView.BufferType.EDITABLE);
            inputBotellin.setText("", TextView.BufferType.EDITABLE);
        } else {
            Toast.makeText(getApplicationContext(),res,Toast.LENGTH_LONG).show();
        }
;    }
}