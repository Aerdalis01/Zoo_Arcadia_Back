import React, { useState } from 'react';

export interface ImageFormProps {
  serviceName: string;
  onImageSelect: (file: File | null) =>void
}

export const ImageForm: React.FC<ImageFormProps> = ({ serviceName, onImageSelect }) => {
  

  const handleImageChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    if (event.target.files && event.target.files[0]) {
      onImageSelect(event.target.files[0]);
    } else {
      onImageSelect(null); // Aucun fichier sélectionné
    }
  };

  return (
    
      <div>
        <label htmlFor="image">Select Image:</label>
        <input
          type="file"
          id="image"
          accept="image/*"
          onChange={handleImageChange}
        />
      </div>
    
  );
};

