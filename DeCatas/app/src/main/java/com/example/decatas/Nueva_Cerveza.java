package com.example.decatas;

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
    public Button btn;

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

        btn = (Button)findViewById(R.id.button2);

        btnTakePhotoClicker b = new btnTakePhotoClicker();
        btn.setOnClickListener(b);

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

    private static final int CAN_REQUEST = 1313;

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(requestCode==CAN_REQUEST){
            final Bitmap bm = (Bitmap) data.getExtras().get("data");

            android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(this);
            builder.setCancelable(true);
            builder.setMessage("¿Quieres guardar esta foto?");

            ImageView img = new ImageView(this);
            img.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.FILL_PARENT));
            img.setImageBitmap(bm);
            img.getLayoutParams().height=100;
            img.getLayoutParams().width=500;

            builder.setView(img);

            builder.setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    dialog.dismiss();

                    //ByteArrayOutputStream stream = new ByteArrayOutputStream();
                    //bm.compress(Bitmap.CompressFormat.JPEG, 100, stream);
                    //byte[] imagen = stream.toByteArray();
                    //String encodedImage = Base64.encodeToString(imagen,Base64.DEFAULT);

                    //Map<String,String> p = new LinkedHashMap<>();
                    //p.put("img",encodedImage);
                    ///p.put("idU",idUsuario);
                    //p.put("idC",idCerveza);

                    //try {
                    //   Connection c = new Connection(getApplicationContext(),"uploadImg.php",p);
                    //   while(c.getRes()==null);
                    //   if(c.getRes().equals("1")){
                    //       Toast.makeText(Valorar_Cerveza.this, "La imagen se pudo guardar", Toast.LENGTH_SHORT).show();
                    //   }else {
                    //       Toast.makeText(Valorar_Cerveza.this, "Error al guardar la imagen", Toast.LENGTH_SHORT).show();
                    //    }
                    //} catch (MalformedURLException e) {
                    //    e.printStackTrace();
                    //}

                }
            });
            builder.setNegativeButton(R.string.cancel, null);
            builder.show();
        }
    }

    private class btnTakePhotoClicker implements View.OnClickListener{

        @Override
        public void onClick(View v) {
            Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
            startActivityForResult(intent,CAN_REQUEST);
        }
    }
}