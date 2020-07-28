package com.example.decatas;

import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.content.FileProvider;

import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import java.io.File;
import java.io.IOException;
import java.net.MalformedURLException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Objects;

public class Nueva_Cerveza extends AppCompatActivity {

    String idUsuario;
    EditText inputName,inputAroma,inputApariencia,inputSabor,inputCuerpo,inputBotellin;
    String name,aroma,apariencia,sabor,botellin,cuerpo;
    static final int REQUEST_IMAGE_CAPTURE = 1;
    static final int REQUEST_TAKE_PHOTO = 1;

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

        inputName.setBackgroundResource(R.drawable.input_normal);
        inputAroma.setBackgroundResource(R.drawable.input_normal);
        inputSabor.setBackgroundResource(R.drawable.input_normal);
        inputCuerpo.setBackgroundResource(R.drawable.input_normal);
        inputApariencia.setBackgroundResource(R.drawable.input_normal);
        inputBotellin.setBackgroundResource(R.drawable.input_normal);
    }

    public void goToUser(View v){
        Intent intent = new Intent(getApplicationContext(),User.class);
        startActivity(intent);
    }

    public void saveBeer(View v) throws MalformedURLException {
        Log.v("Nueva_Cerveza","SaveBeer");
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

        Log.v("Nueva_Cerveza",name);
        Log.v("Nueva_Cerveza",aroma);
        Log.v("Nueva_Cerveza",apariencia);
        Log.v("Nueva_Cerveza",sabor);
        Log.v("Nueva_Cerveza",cuerpo);
        Log.v("Nueva_Cerveza",botellin);

        if(name.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe un nombre",Toast.LENGTH_LONG).show();
            inputName.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","name es null");
            return;
        }
        if(aroma.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para el aroma",Toast.LENGTH_LONG).show();
            inputAroma.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","aroma es null");
            return;
        }
        if(Integer.parseInt(aroma)<0 || Integer.parseInt(aroma)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputAroma.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","aroma outofbounds");
            return;
        }
        if(apariencia.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para la apariencia",Toast.LENGTH_LONG).show();
            inputApariencia.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","apariencia es null");
            return;
        }
        if(Integer.parseInt(apariencia)<0 || Integer.parseInt(apariencia)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputApariencia.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","apariencia outofbounds");
            return;
        }
        if(sabor.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para el sabor",Toast.LENGTH_LONG).show();
            inputSabor.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","sabor es null");
            return;
        }
        if(Integer.parseInt(sabor)<0 || Integer.parseInt(sabor)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputSabor.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","sabor outofbounds");
            return;
        }
        if(cuerpo.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para el cuerpo",Toast.LENGTH_LONG).show();
            inputCuerpo.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","cuerpo es null");
            return;
        }
        if(Integer.parseInt(cuerpo)<0 || Integer.parseInt(cuerpo)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputCuerpo.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","cuerpo outofbounds");
            return;
        }
        if(botellin.equals("")){
            Toast.makeText(getApplicationContext(),"Escribe una valoración para el botellín",Toast.LENGTH_LONG).show();
            inputBotellin.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","botellin es null");
            return;
        }
        if(Integer.parseInt(botellin)<0 || Integer.parseInt(botellin)>10){
            Toast.makeText(getApplicationContext(),"Introduce un valor de 0 a 10",Toast.LENGTH_LONG).show();
            inputBotellin.setBackgroundResource(R.drawable.input_error);
            Log.v("Nueva_Cerveza","botellin outofbounds");
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
        if(!res.equals("1")){
            Toast.makeText(getApplicationContext(),res,Toast.LENGTH_LONG).show();
        } else {
            Toast.makeText(getApplicationContext(),"La cerveza se guardó correctamente",Toast.LENGTH_LONG).show();
            inputName.setText("", TextView.BufferType.EDITABLE);
            inputAroma.setText("", TextView.BufferType.EDITABLE);
            inputApariencia.setText("", TextView.BufferType.EDITABLE);
            inputSabor.setText("", TextView.BufferType.EDITABLE);
            inputCuerpo.setText("", TextView.BufferType.EDITABLE);
            inputBotellin.setText("", TextView.BufferType.EDITABLE);
        }
;    }

    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    public void dispatchTakePictureIntent(View v) throws IOException {
        Intent takePictureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        if (takePictureIntent.resolveActivity(getPackageManager()) != null) {
            File photoFile = null;
            photoFile = createImageFile();
            if (photoFile != null) {
                    Uri photoURI = FileProvider.getUriForFile(Objects.requireNonNull(getApplicationContext()),
                            BuildConfig.APPLICATION_ID + ".fileprovider",
                        photoFile);
                takePictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, photoURI);
                startActivityForResult(takePictureIntent, REQUEST_TAKE_PHOTO);
                Bitmap bitmap = MediaStore.Images.Media.getBitmap(this.getContentResolver(), photoURI);
            }
        }
    }

    String currentPhotoPath;

    private File createImageFile() throws IOException {
        String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String imageFileName = "JPEG_" + timeStamp + "_";
        File storageDir = getExternalFilesDir(Environment.DIRECTORY_PICTURES);
        File image = File.createTempFile(
                imageFileName,  /* prefix */
                ".jpg",         /* suffix */
                storageDir      /* directory */
        );
        currentPhotoPath = image.getAbsolutePath();
        return image;
    }
}